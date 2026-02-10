<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;

class SmmService
{

    protected $priceMarkup = 50 * 1.20;


    public function services()
    {
        // Cache the result for 60 minutes
        $services = Cache::remember('smm_services', 3600, function () {
            $response = Http::asForm()->post(
                config('services.smm_provider.url'),
                [
                    'key'    => config('services.smm_provider.key'),
                    'action' => 'services',
                ]
            );

            return $response->json();
        });
        $services = $this->applyPriceMarkup($services);
        return $this->filterHiddenServices($services);
    }



    public function applyPriceMarkup(array $services)
    {
        return array_map(function ($service) {
            $service['rate'] = $service['rate'] * $this->priceMarkup;
            return $service;
        }, $services);
    }





    public function addOrder(array $data)
    {
        $payload = [
            'key'      => config('services.smm_provider.key'),
            'action'   => 'add',
            'service'  => $data['service'],
            'link'     => $data['link'],
            'quantity' => $data['quantity'],
        ];

        if (!empty($data['runs'])) $payload['runs'] = $data['runs'];
        if (!empty($data['interval'])) $payload['interval'] = $data['interval'];
        if (!empty($data['comments'])) $payload['comments'] = $data['comments'];

        $response = Http::asForm()->post(config('services.smm_provider.url'), $payload);

        return $response->json();
    }

    public function getBalance()
    {
        $response = Http::asForm()->post(config('services.smm_provider.url'), [
            'key'    => config('services.smm_provider.key'),
            'action' => 'balance',
        ]);

        return $response->json();
    }





    public function getMultipleOrdersStatus(array $orderIds)
    {

        $chunks = array_chunk($orderIds, 100);
        $results = [];

        foreach ($chunks as $chunk) {
            $response = Http::asForm()->post(config('services.smm_provider.url'), [
                'key'    => config('services.smm_provider.key'),
                'action' => 'status',
                'orders' => implode(',', $chunk),
            ]);

            $data = $response->json();
            $results = $results + $data;
        }

        return $results;
    }


    public function refill($orderId)
    {
        $response = Http::asForm()->post(config('services.smm_provider.url'), [
            'key'    => config('services.smm_provider.key'),
            'action' => 'refill',
            'order'  => $orderId,
        ]);

        return $response->json();
    }


    public function cancel($orderId)
    {
        $response = Http::asForm()->post(config('services.smm_provider.url'), [
            'key'    => config('services.smm_provider.key'),
            'action' => 'cancel',
            'order'  => $orderId,
        ]);

        return $response->json();
    }


    public function multipleRefillStatus($refillIds)
    {
        // If array, implode. If string, leave as is.
        $refillParam = is_array($refillIds) ? implode(',', $refillIds) : $refillIds;

        $response = Http::asForm()->post(config('services.smm_provider.url'), [
            'key'    => config('services.smm_provider.key'),
            'action' => 'refill_status',
            'refill' => $refillParam,
        ]);

        return $response->json();
    }
    /**
     * Get list of service IDs to hide from the website.
     * @return array
     */
    protected function getHiddenServiceIds()
    {
        return [
            4823, 4825,
        ];
    }

    /**
     * Filter out hidden services.
     * @param array $services
     * @return array
     */
    protected function filterHiddenServices(array $services)
    {
        $hiddenIds = $this->getHiddenServiceIds();

        if (empty($hiddenIds)) {
            return $services;
        }

        $filtered = array_filter($services, function ($service) use ($hiddenIds) {
            return !in_array($service['service'], $hiddenIds);
        });

        return array_values($filtered);
    }
}

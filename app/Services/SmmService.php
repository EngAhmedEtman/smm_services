<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;


class SmmService
{
    public function services()
    {
        /** @var Response $response */
        $response = Http::asForm()->post(
            config('services.dragon_smm.url'),
            [
                'key'    => config('services.dragon_smm.key'),
                'action' => 'services',
            ]
        );

        return $response->json();
    }



public function addOrder(array $data)
{
    $payload = [
        'key'      => config('services.dragon_smm.key'),
        'action'   => 'add',
        'service'  => $data['service'],
        'link'     => $data['link'],
        'quantity' => $data['quantity'],
    ];

    if (!empty($data['runs'])) $payload['runs'] = $data['runs'];
    if (!empty($data['interval'])) $payload['interval'] = $data['interval'];

    $response = Http::asForm()->post(config('services.dragon_smm.url'), $payload);

    return $response->json();
}



    

    public function getMultipleOrdersStatus(array $orderIds)
    {

        $chunks = array_chunk($orderIds, 100);
        $results = [];

        foreach ($chunks as $chunk) {
            $response = Http::asForm()->post(config('services.dragon_smm.url'), [
                'key'    => config('services.dragon_smm.key'),
                'action' => 'status',
                'orders' => implode(',', $chunk),
            ]);

            $data = $response->json();
            $results = $results + $data;
        }

        return $results;
    }


}

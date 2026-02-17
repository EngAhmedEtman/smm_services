<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmmService;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class controlSrevices extends Controller
{
    protected $smmService;

    public function __construct(SmmService $smmService)
    {
        $this->smmService = $smmService;
    }

    /**
     * Display the control page with all services.
     */
    public function index(Request $request)
    {
        // Fetch all services merged with local settings
        // false = get all (active and inactive)
        $allServices = $this->smmService->getServicesWithSettings(false);

        // Manual Pagination
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $currentItems = array_slice($allServices, $offset, $perPage);

        $services = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            count($allServices),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('settings.controlSrevices', compact('services'));
    }

    /**
     * Update service settings (active status and custom category).
     */
    public function update(Request $request)
    {
        $data = $request->input('services', []);

        foreach ($data as $serviceId => $settings) {

            // Check if we need to save this record
            // We save if:
            // 1. It's inactive (default is active)
            // 2. It has a custom category
            // 3. Or if a record already exists, we update it.

            $isActive = isset($settings['active']);
            $customCategory = !empty($settings['custom_category']) ? $settings['custom_category'] : null;

            // Find or create local record
            $service = Service::firstOrNew(['service_id' => $serviceId]);

            // Only save if there's a change from default or existing record needs update
            if (!$isActive || !empty($customCategory) || $service->exists) {

                // If it's active and has no custom category, and it exists, we could delete it to save space,
                // but keeping it is safer for future extensibility.

                $service->is_active = $isActive;
                $service->custom_category = $customCategory;

                // We need to fill required fields if it's new (though we only need service_id for the merge logic)
                // However, the Service model requires name, rate, etc. if we scrutinized it, but 
                // let's check the migration. Columns are not nullable.
                // We should probably fill them from the API data if it's a new record to avoid SQL errors.
                // BUT, the merge logic only looks at api data overlaid with local data.
                // Let's check if we can make other fields nullable or if we should just save dummy data/api data.

                // Fetching specific service data to fill required fields is expensive in a loop.
                // Better strategy: The Service model should basically just store overrides linked to service_id.
                // But the current migration "create_services_table" defined them as required.
                // We should assume for now we might need to fill them or make them nullable.
                // For this implementation, I will just fill them with defaults or data from request if available.
                // To do this right, I'll pass the name/rate from the form as hidden inputs.

                $service->name = $settings['name'] ?? 'Unknown';
                $service->rate = $settings['rate'] ?? 0;
                $service->min = $settings['min'] ?? 0;
                $service->max = $settings['max'] ?? 0;
                $service->category = $settings['original_category'] ?? 'Uncategorized';

                $service->save();
            }
        }

        // Clear cache to reflect changes immediately
        Cache::forget('smm_services');

        return back()->with('success', 'تم تحديث إعدادات الخدمات بنجاح');
    }
}

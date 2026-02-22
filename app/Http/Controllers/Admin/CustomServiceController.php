<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CustomServiceController extends Controller
{
    /**
     * Show the custom services management page.
     */
    public function index()
    {
        $customServices = Service::where('is_custom', true)->latest()->get();
        return view('settings.custom-services', compact('customServices'));
    }

    /**
     * Store a new custom service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'min' => 'required|integer|min:1',
            'max' => 'required|integer|min:1',
        ]);

        // Generate a random ID for custom service to simulate SMM ID format
        $serviceId = 'c_' . mt_rand(10000, 99999);

        Service::create([
            'service_id' => $serviceId,
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'rate' => $request->rate,
            'min' => $request->min,
            'max' => $request->max,
            'type' => 'Default',
            'provider' => 'Local', // Mark provider as Local
            'is_custom' => true,
            'is_active' => true,
        ]);

        // Clear cache to reflect new service
        Cache::forget('smm_services');

        return back()->with('success', 'تم إضافة الخدمة المخصصة بنجاح.');
    }

    /**
     * Delete a custom service.
     */
    public function destroy($id)
    {
        $service = Service::where('id', $id)->where('is_custom', true)->firstOrFail();

        $service->delete();

        // Clear cache
        Cache::forget('smm_services');

        return back()->with('success', 'تم حذف الخدمة المخصصة.');
    }
}

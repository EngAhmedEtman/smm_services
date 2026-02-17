<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmmService;
use App\Models\MainCategory;
use App\Models\CategorySetting;

class ControlCategoriesController extends Controller
{
    protected $smmService;

    public function __construct(SmmService $smmService)
    {
        $this->smmService = $smmService;
    }

    public function index()
    {
        // 1. Fetch all services from API (cached)
        $apiServices = $this->smmService->services();

        // 2. Extract unique categories (original names from API)
        $apiCategories = collect($apiServices)->pluck('category')->unique()->values();

        // 3. Fetch Local Settings
        $categorySettings = \App\Models\CategorySetting::all()->keyBy('original_category_name');

        // 4. Fetch Main Categories
        $mainCategories = \App\Models\MainCategory::all();

        // 5. Merge Data
        $categories = $apiCategories->map(function ($catName) use ($categorySettings) {
            $setting = $categorySettings->get($catName);
            return [
                'original_name' => $catName,
                'main_category_id' => $setting ? $setting->main_category_id : null,
                'custom_name' => $setting ? $setting->custom_name : null,
                'is_active' => $setting ? $setting->is_active : true, // Default active
                'sort_order' => $setting ? $setting->sort_order : 0,
            ];
        });

        return view('settings.controlCategories', compact('categories', 'mainCategories'));
    }

    public function update(Request $request)
    {
        $data = $request->input('categories', []);

        foreach ($data as $originalName => $settings) {

            // Check if we need to save/update
            $isActive = isset($settings['active']);
            $mainCategoryId = !empty($settings['main_category_id']) ? $settings['main_category_id'] : null;
            $customName = !empty($settings['custom_name']) ? $settings['custom_name'] : null;
            $sortOrder = $settings['sort_order'] ?? 0;

            // Find or new
            $categorySetting = \App\Models\CategorySetting::firstOrNew(['original_category_name' => $originalName]);

            // Save if there's any change/override
            // We save if inactive, or has main category, or has custom name, or has sort order, or already exists
            if (!$isActive || $mainCategoryId || $customName || $sortOrder != 0 || $categorySetting->exists) {
                $categorySetting->is_active = $isActive;
                $categorySetting->main_category_id = $mainCategoryId;
                $categorySetting->custom_name = $customName;
                $categorySetting->sort_order = $sortOrder;
                $categorySetting->save();
            }
        }

        return back()->with('success', 'تم تحديث إعدادات الأقسام بنجاح');
    }

    public function storeMainCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\MainCategory::create([
            'name' => $request->name,
            'is_active' => true,
        ]);

        return back()->with('success', 'تم إضافة القسم الرئيسي بنجاح');
    }
}

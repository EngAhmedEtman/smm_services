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

    public function index(Request $request)
    {
        // 1. Fetch all services from API (cached)
        $apiServices = $this->smmService->services();

        // 2. Extract unique categories (original names from API)
        $apiCategories = collect($apiServices)->pluck('category')->unique()->values();

        // 3. Fetch Local Settings
        $categorySettings = CategorySetting::all()->keyBy('original_category_name');

        // 4. Fetch Main Categories (Sorted by sort_order)
        $mainCategories = MainCategory::orderBy('sort_order', 'asc')->get();

        // 5. Merge Data
        $categories = $apiCategories->map(function ($catName) use ($categorySettings) {
            $setting = $categorySettings->get($catName);
            return [
                'original_name' => $catName,
                'main_category_id' => $setting ? $setting->main_category_id : null,
                'is_active' => $setting ? $setting->is_active : true, // Default active
                'sort_order' => $setting ? $setting->sort_order : 0,
            ];
        });

        // Search Filter
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $categories = $categories->filter(function ($cat) use ($search) {
                return (
                    strpos(strtolower($cat['original_name']), $search) !== false
                );
            });
        }

        // Pagination
        $page = $request->input('page', 1);
        $perPage = 20;
        $slicedDetails = $categories->slice(($page - 1) * $perPage, $perPage)->values();

        $categories = new \Illuminate\Pagination\LengthAwarePaginator(
            $slicedDetails,
            $categories->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('settings.controlCategories', compact('categories', 'mainCategories'));
    }

    public function update(Request $request)
    {
        $data = $request->input('categories', []);

        foreach ($data as $settings) {
            $originalName = $settings['original_name'] ?? null;

            if (!$originalName) {
                continue;
            }

            // Check if we need to save/update
            $isActive = isset($settings['active']);
            $mainCategoryId = !empty($settings['main_category_id']) ? $settings['main_category_id'] : null;
            $sortOrder = $settings['sort_order'] ?? 0;

            // Find or new
            $categorySetting = \App\Models\CategorySetting::firstOrNew(['original_category_name' => $originalName]);

            // Save if there's any change/override
            // We save if inactive, or has main category, or has sort order, or already exists
            if (!$isActive || $mainCategoryId || $sortOrder != 0 || $categorySetting->exists) {
                $categorySetting->is_active = $isActive;
                $categorySetting->main_category_id = $mainCategoryId;
                // $categorySetting->custom_name = null; // We removed this feature
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
            'sort_order' => 'nullable|integer',
        ]);

        \App\Models\MainCategory::create([
            'name' => $request->name,
            'is_active' => true,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'تم إضافة القسم الرئيسي بنجاح');
    }

    public function updateMainCategories(Request $request)
    {
        $data = $request->input('main_categories', []);

        foreach ($data as $id => $settings) {
            $mainCat = \App\Models\MainCategory::find($id);
            if ($mainCat) {
                // Determine active status: if checkbox is checked, it sends '1'. If unchecked, it sends nothing.
                // Or we can assume all appearing in list are active unless we add a specific toggle.
                // For now, let's just update name and sort order.

                if (isset($settings['name'])) {
                    $mainCat->name = $settings['name'];
                }

                if (isset($settings['sort_order'])) {
                    $mainCat->sort_order = $settings['sort_order'];
                }

                $mainCat->save();
            }
        }

        return back()->with('success', 'تم تحديث الأقسام الرئيسية بنجاح');
    }

    public function destroyMainCategory($id)
    {
        $mainCat = \App\Models\MainCategory::findOrFail($id);

        // Optional: Check if used? Or just set sub-categories to null?
        // Let's just delete it. Sub-categories logic might need to handle null main_category_id (it already does).
        $mainCat->delete();

        return back()->with('success', 'تم حذف القسم الرئيسي بنجاح');
    }
}

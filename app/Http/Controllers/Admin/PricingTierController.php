<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingTier;
use Illuminate\Http\Request;

class PricingTierController extends Controller
{
    public function index()
    {
        $tiers = PricingTier::orderBy('min_count')->get();
        return view('admin.pricing.index', compact('tiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_count' => 'required|integer|min:1',
            'max_count' => 'nullable|integer|gt:min_count',
            'price_per_message' => 'required|numeric|min:0',
        ]);

        PricingTier::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة شريحة التسعير بنجاح');
    }

    public function update(Request $request, PricingTier $pricingTier)
    {
        $request->validate([
            'min_count' => 'required|integer|min:1',
            'max_count' => 'nullable|integer|gt:min_count',
            'price_per_message' => 'required|numeric|min:0',
        ]);

        $pricingTier->update($request->all());

        return redirect()->back()->with('success', 'تم تحديث شريحة التسعير بنجاح');
    }

    public function destroy(PricingTier $pricingTier)
    {
        $pricingTier->delete();
        return redirect()->back()->with('success', 'تم حذف شريحة التسعير بنجاح');
    }
}

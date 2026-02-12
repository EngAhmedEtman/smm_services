<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // إحصائيات بسيطة
        $stats = [
            'total_orders' => $user->orders()->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'pending_orders' => $user->orders()->whereIn('status', ['pending', 'processing', 'inprogress', 'in progress'])->count(),
            'total_spent' => $user->orders()->sum('price') ?? 0,
        ];

        // Chart Data 1: Orders Activity (Last 7 Days)
        $ordersActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $user->orders()->whereDate('created_at', $date)->count();
            $ordersActivity[] = [
                'date' => now()->subDays($i)->format('D'), // Day name
                'count' => $count,
                'height' => $count > 0 ? min($count * 10, 100) : 5, // Normalize height
            ];
        }

        // Chart Data 2: Service Distribution
        $topServices = $user->orders()
            ->select('service_id')
            ->selectRaw('count(*) as count')
            ->groupBy('service_id')
            ->orderByDesc('count')
            ->limit(3)
            ->with('service')
            ->get();

        $totalOrders = $user->orders()->count();
        $serviceDistribution = $topServices->map(function ($item) use ($totalOrders) {
            return [
                'name' => $item->service->name ?? 'Unknown Service',
                'percentage' => $totalOrders > 0 ? round(($item->count / $totalOrders) * 100) : 0,
            ];
        });

        return view('profile.edit', [
            'user' => $user,
            'stats' => $stats,
            'ordersActivity' => $ordersActivity,
            'serviceDistribution' => $serviceDistribution,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

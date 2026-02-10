<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmmService;
use Illuminate\Support\Facades\Auth;

class FavoriteServiceController extends Controller
{
    protected $smmService;

    /**
     * Dependency Injection for SmmService
     * @param SmmService $smmService
     */
    public function __construct(SmmService $smmService)
    {
        $this->smmService = $smmService;
    }

    /**
     * Toggle the favorite status of a service for the authenticated user.
     * Adds or removes the service from the user's favorites list.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeFavorite(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
        ]);

        $result = $this->toggleFavoriteStatus((int)$request->service_id);

        return response()->json($result);
    }

    /**
     * Display the list of favorite services for the authenticated user.
     * Fetches details from SMM API based on stored favorite IDs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Get User's Favorite Service IDs
        $favoriteIds = $this->getUserFavoriteIds();

        // 2. Fetch Detailed Info for these services
        $favoriteServices = $this->getFavoriteServicesDetails($favoriteIds);

        return view('services.favoriteServices', compact('favoriteServices'));
    }

    // =========================================================================
    // PRIVATE HELPER METHODS
    // =========================================================================

    /**
     * Toggle logic: if exists -> delete, else -> create.
     * Returns an array with status and message.
     *
     * @param int $serviceId
     * @return array
     */
    private function toggleFavoriteStatus(int $serviceId): array
    {
        $user = Auth::user();
        $exists = $user->favoriteServices()->where('service_id', $serviceId)->exists();

        if ($exists) {
            $user->favoriteServices()->where('service_id', $serviceId)->delete();
            return [
                'status' => 'removed',
                'message' => 'تم الإزالة من المفضلة'
            ];
        }

        $user->favoriteServices()->create(['service_id' => $serviceId]);
        return [
            'status' => 'added',
            'message' => 'تم الإضافة إلى المفضلة'
        ];
    }

    /**
     * Retrieve array of favorite service IDs for the current user.
     *
     * @return array
     */
    private function getUserFavoriteIds(): array
    {
        return Auth::user()->favoriteServices()
            ->pluck('service_id')
            ->map(fn($id) => (int)$id) // Ensure integer type
            ->toArray();
    }

    /**
     * Fetch all services from SMM Service and filter by favorite IDs.
     *
     * @param array $favoriteIds
     * @return array
     */
    private function getFavoriteServicesDetails(array $favoriteIds): array
    {
        // Fetch all services from API (cached usually)
        $allServices = $this->smmService->services();

        // Filter valid services that match the favorite IDs
        return array_filter($allServices, function ($service) use ($favoriteIds) {
            return in_array($service['service'], $favoriteIds);
        });
    }
}

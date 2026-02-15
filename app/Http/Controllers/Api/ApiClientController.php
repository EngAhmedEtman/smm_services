<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ApiClient;


class ApiClientController extends Controller
{

    public function create()
    {
        if (!auth()->user()->allow_api_key) {
            return redirect()->route('dashboard')->with('error', 'غير مسموح لك بدخول هذه الصفحة يرجي التواصل مع الادارة للتفعيل 01558551073');
        }

        $token = $this->checkToken();
        return view('whatsapp api.create', compact('token'));
    }




    public function createToken(Request $request)
    {
        if (!auth()->user()->allow_api_key) {
            return response()->json([
                'success' => false,
                'message' => 'غير مسموح لك بدخول هذه الصفحة يرجي التواصل مع الادارة للتفعيل 01558551073'
            ], 403);
        }

        $userId = auth()->id(); // أو ID ثابت لو Admin

        // نتحقق هل User عنده Token بالفعل
        $existing = ApiClient::where('user_id', $userId)->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'This user already has a token.',
                'api_key' => $existing->api_key
            ]);
        }

        $token = Str::random(40);

        // إنشاء العميل وحفظه في DB
        $client = ApiClient::create([
            'user_id' => $userId,
            'api_key' => $token,
            'balance' => 0,
            'status' => 1
        ]);


        redirect()->route('api.create')->with('success', 'تم انشاء التوكن بنجاح');
    }

    private function checkToken()
    {
        $userId = auth()->id();
        $existing = ApiClient::where('user_id', $userId)->first();
        if ($existing) {
            return $existing->api_key;
        }
        return null;
    }
}

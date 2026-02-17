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
            return redirect()->route('dashboard')->with('error', 'غير مسموح لك بدخول هذه الصفحة. للتفعيل، اضغط على "واتساب API" من القائمة الجانبية للتواصل معنا.');
        }

        $token = $this->checkToken();
        return view('whatsapp api.create', compact('token'));
    }




    public function createToken(Request $request)
    {
        if (!auth()->user()->allow_api_key) {
            return response()->json([
                'success' => false,
                'message' => 'غير مسموح لك بدخول هذه الصفحة. للتفعيل، اضغط على "واتساب API" من القائمة الجانبية للتواصل معنا.'
            ], 403);
        }

        $userId = auth()->id(); // أو ID ثابت لو Admin

        // نتحقق هل User عنده Token بالفعل
        $existing = ApiClient::where('user_id', $userId)->first();

        if ($existing) {
            return redirect()->route('create-token')->with('info', 'لديك مفتاح (Token) بالفعل.');
        }

        $token = Str::random(40);

        // إنشاء العميل وحفظه في DB
        $client = ApiClient::create([
            'user_id' => $userId,
            'api_key' => $token,
            'balance' => 0,
            'status' => 1
        ]);

        return redirect()->route('create-token')->with('success', 'تم انشاء التوكن بنجاح');
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

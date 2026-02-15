<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiClient;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. نجيب المفتاح من الـ Header
        $key = $request->header('ETVIRAL-WHATSAPP-API-KEY');

        // 2. لو مفيش مفتاح أصلاً
        if (!$key) {
            return response()->json([
                'success' => false,
                'message' => 'API Key is missing. Please provide ETVIRAL-WHATSAPP-API-KEY in headers.'
            ], 401);
        }

        // 3. ندور على العميل بالمفتاح ده
        $client = ApiClient::where('api_key', $key)->first();

        // 4. لو المفتاح غلط
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Key.'
            ], 401);
        }

        // 5. نتأكد إن حساب العميل شغال (مش معمول له بلوك مثلاً)
        if (!$client->status) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is suspended. Please contact support.'
            ], 403);
        }

        // 6. نحفظ بيانات العميل في الـ Request عشان نستخدمها في الـ Controller براحتنا
        $request->attributes->set('api_client', $client);

        return $next($request);
    }
}
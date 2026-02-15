<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WolfixbotService;

class MessageController extends Controller
{
    protected $wolfixbot;

    // بنعمل Inject للـ Service هنا عشان نستخدمها
    public function __construct(WolfixbotService $wolfixbot)
    {
        $this->wolfixbot = $wolfixbot;
    }

    public function sendText(Request $request)
    {
        // 1. التحقق من المدخلات اللي جاية من العميل
        $request->validate([
            'number' => 'required|string',
            'message' => 'required|string',
        ]);

        // 2. نجيب بيانات العميل من الـ Request (اللي الـ Middleware حطها)
        $client = $request->attributes->get('api_client');

        // (هنا هنحط كود التحقق من الرصيد وخصمه بعدين - النقطة 7)

        // 3. نبعت الطلب للـ Service بتاعتنا باستخدام الـ instance_id بتاع العميل ده
        $result = $this->wolfixbot->sendText(
            $client->instance_id, 
            $request->number, 
            $request->message
        );

        // 4. نرجع النتيجة للعميل
        return response()->json($result);
    }
}
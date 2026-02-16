<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Whatsapp;
use Illuminate\Support\Str;

class WhatsappController extends Controller
{

    protected $token = '6983b5e6a0994';

    protected $baseUrl = 'https://wolfixbot.com/api';
    public function connect()
    {
        // 1️⃣ Create Instance
        $instanceResponse = Http::get(
            $this->baseUrl . '/create_instance',
            ['access_token' => $this->token]
        )->json();

        $instanceId = $instanceResponse['instance_id'];

        // 2️⃣ Get QR Code
        $qrResponse = Http::get(
            $this->baseUrl . '/get_qrcode',
            [
                'instance_id' => $instanceId,
                'access_token' => $this->token
            ]
        )->json();


        // Check if instance already exists to prevent duplicates
        Whatsapp::updateOrCreate(
            ['instance_id' => $instanceId],
            [
                'user_id' => auth()->id(),
                'status'  => 'pending' // Reset to pending since we are generating a new QR
            ]
        );


        return view('whatsapp.connect', [
            'instance_id' => $instanceId,
            'qr'          => $qrResponse['base64'],
            'expires_in'  => $qrResponse['expires_in'],
        ]);
    }

    public function updateNumber(Request $request)
    {
        $request->validate([
            'instance_id' => 'required',
            'phone_number' => 'required|numeric'
        ]);

        Whatsapp::where('instance_id', $request->instance_id)
            ->where('user_id', auth()->id()) // Security check
            ->update(['phone_number' => $request->phone_number]);

        return response()->json(['status' => 'success', 'message' => 'تم حفظ الرقم بنجاح']);
    }

    public function scanInstance($instanceId)
    {
        // Get QR Code for EXISTING instance
        $response = Http::get(
            $this->baseUrl . '/get_qrcode',
            [
                'instance_id' => $instanceId,
                'access_token' => $this->token
            ]
        );

        $qrResponse = $response->json();

        // Check if QR retrieval failed
        if (isset($qrResponse['status']) && $qrResponse['status'] === 'error') {

            // If Instance Invalidated -> Delete it and redirect to create NEW one
            if (isset($qrResponse['message']) && stripos($qrResponse['message'], 'Instance ID Invalidated') !== false) {
                Whatsapp::where('instance_id', $instanceId)->delete();
                return redirect()->route('whatsapp.connect')->with('error', 'انتهت صلاحية هذا الحساب تماماً. جاري إنشاء حساب جديد...');
            }

            return redirect()->route('whatsapp.accounts')->with('error', 'فشل جلب QR Code: ' . ($qrResponse['message'] ?? 'Unknown Error'));
        }

        // Update local status just in case
        Whatsapp::where('instance_id', $instanceId)->update(['status' => 'pending']);

        return view('whatsapp.connect', [
            'instance_id' => $instanceId,
            'qr'          => $qrResponse['base64'],
            'expires_in'  => $qrResponse['expires_in'],
        ]);
    }

    public function index()
    {
        // 1️⃣ جلب كل الـ instances الغير متصلة
        $notConnected = Whatsapp::all()->where('user_id', auth()->id());

        // 2️⃣ شيك على كل واحدة وحفظ الحالة الجديدة
        foreach ($notConnected as $instance) {
            // افترض إن debugStatus بترجع الحالة الجديدة
            $statusResponse = $this->debugStatus($instance->instance_id);

            // استخراج الحالة من الرد (تخمين بناءً على شكل الرد)
            // لو الرد فيه "status": "success" والرسالة "connected" أو شبيه بذلك
            // هنا محتاجين نعرف شكل الرد بالظبط عشان نحدد connected ولا لأ

            // افتراضياً: لو success يبقى connected، لو error يبقى disconnected/pending
            $newStatus = 'pending';
            if (isset($statusResponse['status'])) {
                if ($statusResponse['status'] === 'success') {
                    $newStatus = 'connected';
                } else {
                    $newStatus = 'disconnected'; // Or keep pending based on message
                }
            }

            // حدث الحالة في قاعدة البيانات
            $instance->update(['status' => $newStatus]);
        }

        // 3️⃣ بعد التحديث، جلب كل الـ instances مرة تانية لعرضها
        $accounts = Whatsapp::where('user_id', auth()->id())->latest()->get();

        // 4️⃣ عرضهم في الـ view
        return view('whatsapp.accounts', compact('accounts'));
    }


    public function debugStatus($instanceId)
    {
        $response = Http::get("$this->baseUrl/set_webhook", [
            'webhook_url' => 'https://webhook.site/1b25464d6833784f96eef4xxxxxxxxxx',
            'enable'      => true,
            'instance_id' => $instanceId,
            'access_token' => $this->token
        ])->json();

        return $response;
    }


    public function rebootInstance($instanceId)
    {
        $instanceId = trim($instanceId);
        $token = trim($this->token);

        // Try GET request as POST is failing (returning homepage)
        // Similar to create_instance and get_qrcode which use GET
        $httpResponse = Http::get("{$this->baseUrl}/reboot", [
            'instance_id'  => $instanceId,
            'access_token' => $token
        ]);

        $json = $httpResponse->json();

        // Strict Check: Only proceed if status is explicitly success
        if (isset($json['status']) && $json['status'] === 'success') {
            Whatsapp::where('instance_id', $instanceId)->update(['status' => 'pending']);
            return back()->with('success', 'تم إعادة التشغيل (تسجيل الخروج) بنجاح.');
        }

        // Return API error message (Raw Body + Status Code)
        $status = $httpResponse->status();
        $rawBody = $httpResponse->body();
        // If HTML, strip tags to show content
        $errorPreview = Str::limit(strip_tags($rawBody), 200);
        return back()->with('error', "فشل ($status): " . ($json['message'] ?? $errorPreview));
    }

    public function resetInstance($instanceId)
    {
        $instanceId = trim($instanceId);
        $token = trim($this->token);

        // Try GET request as POST is failing
        $httpResponse = Http::get("{$this->baseUrl}/reset_instance", [
            'instance_id'  => $instanceId,
            'access_token' => $token
        ]);

        $json = $httpResponse->json();

        // Strict Check & Handle "Account does not exist" as success
        $success = false;

        // Check for standard success
        if (isset($json['status']) && $json['status'] === 'success') {
            $success = true;
        }

        // Also maximize robustness: if API says "Account does not exist", it's effectively deleted
        if (isset($json['message']) && stripos($json['message'], 'Account does not exist') !== false) {
            $success = true;
        }

        if ($success) {
            Whatsapp::where('instance_id', $instanceId)->delete();
            return back()->with('success', 'تم انتهاء الحذف وإلغاء الربط نهائياً.');
        }

        $status = $httpResponse->status();
        $rawBody = $httpResponse->body();
        $errorPreview = Str::limit(strip_tags($rawBody), 200);
        return back()->with('error', "فشل الحذف ($status): " . ($json['message'] ?? $errorPreview));
    }

    public function reconnect($instanceId)
    {
        $instanceId = trim($instanceId);
        $token = trim($this->token);

        // Try GET request pattern as currently successful with other endpoints
        $httpResponse = Http::get("{$this->baseUrl}/reconnect", [
            'instance_id'  => $instanceId,
            'access_token' => $token
        ]);

        $json = $httpResponse->json();

        if (isset($json['status']) && $json['status'] === 'success') {
            return back()->with('success', 'تم إعادة محاولة الاتصال بنجاح.');
        }

        // Check for specific "not activated" OR "Invalidated" error => Redirect to Scan
        if (isset($json['message']) && (
            stripos($json['message'], 'not been activated yet') !== false ||
            stripos($json['message'], 'Instance ID Invalidated') !== false
        )) {
            return redirect()->route('whatsapp.scan', $instanceId)->with('error', 'هذا الحساب يحتاج إلى إعادة مسح الكود (Scan) لتفعيله.');
        }

        $status = $httpResponse->status();
        $rawBody = $httpResponse->body();
        $errorPreview = Str::limit(strip_tags($rawBody), 200);
        return back()->with('error', "فشل إعادة الاتصال ($status): " . ($json['message'] ?? $errorPreview));
    }



    //test fot send message
    /*
*/
    public function test()
    {
        $instances = Whatsapp::where('user_id', auth()->id())->get();
        return view('whatsapp.test', compact('instances'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'message' => 'required',
            'instance_id' => 'required',
        ]);

        // Increase timeout to match API
        set_time_limit(120);

        try {
            $cleanNumber = preg_replace('/[^0-9]/', '', $request->number); // Remove + and any non-numeric chars

            $response = Http::timeout(60)->post($this->baseUrl . '/send', [
                'number' => $cleanNumber,
                'type' => 'text',
                'message' => $request->message,
                'instance_id' => $request->instance_id,
                'access_token' => $this->token,
            ]);

            return back()->with('api_response', $response->json());
        } catch (\Exception $e) {
            return back()->with('api_response', [
                'status' => 'error',
                'message' => 'حدث خطأ أثناء الاتصال بالـ API: ' . $e->getMessage() . ' (ربما الهاتف غير متصل بالإنترنت)'
            ]);
        }
    }





    public function buttons()
    {
        return view('whatsapp.buttons');
    }
    public function apiDocumentation()
    {
        return view('whatsapp api.doc');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Exception;

class MessageController extends Controller
{
    private $baseUrl;
    private $accessToken;

    public function __construct()
    {
        // يُفضل سحب التوكن من config/services.php
        $this->baseUrl = config('services.whatsapp.url');
        $this->accessToken = config('services.whatsapp.token');
    }

    public function sendText(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'message' => 'required',
            'instance_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        // Increase timeout to match API
        set_time_limit(120);

        try {
            $cleanNumber = preg_replace('/[^0-9]/', '', $request->number); // Remove + and any non-numeric chars

            $response = Http::timeout(60)->post($this->baseUrl . '/send', [
                'number' => $cleanNumber,
                'type' => 'text',
                'message' => $request->message,
                'instance_id' => $request->instance_id,
                'access_token' => $this->accessToken,
            ]);

            if ($response instanceof Response) {
                return response()->json($response->json(), $response->status());
            }

            // Fallback if response is not standard object
            return response()->json([
                'status' => 'error',
                'message' => 'استجابة غير صالحة من الـ API'
            ], 500);
        } catch (RequestException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل الاتصال: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء الاتصال بالـ API: ' . $e->getMessage()
            ], 500);
        }
    }


    public function sendMedia(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'message' => 'required',
            'instance_id' => 'required',
            'media_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        // Increase timeout to match API
        set_time_limit(120);

        if ($request->hasFile('media_url')) {
            $file = $request->file('media_url');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/whatsapp_media'), $fileName);
            $mediaUrl = url('uploads/whatsapp_media/' . $fileName);
        } else {
            $mediaUrl = $request->media_url;
        }

        try {
            $cleanNumber = preg_replace('/[^0-9]/', '', $request->number); // Remove + and any non-numeric chars

            $response = Http::timeout(60)->post($this->baseUrl . '/send', [
                'number' => $cleanNumber,
                'type' => 'media',
                'message' => $request->message,
                'media_url' => $mediaUrl,
                'instance_id' => $request->instance_id,
                'access_token' => $this->accessToken,
            ]);

            if ($response instanceof Response) {
                return response()->json($response->json(), $response->status());
            }

            // Fallback if response is not standard object
            return response()->json([
                'status' => 'error',
                'message' => 'استجابة غير صالحة من الـ API'
            ], 500);
        } catch (RequestException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل الاتصال: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء الاتصال بالـ API: ' . $e->getMessage()
            ], 500);
        }
    }
}

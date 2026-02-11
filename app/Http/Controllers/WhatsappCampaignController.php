<?php

namespace App\Http\Controllers;

use App\Models\WhatsappCampaign;
use App\Models\WhatsappContact;
use App\Models\Whatsapp;
use Illuminate\Http\Request;

class WhatsappCampaignController extends Controller
{
    public function index()
    {
        $campaigns = WhatsappCampaign::where('user_id', auth()->id())->latest()->paginate(10);
        return view('whatsapp.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $groups = WhatsappContact::where('user_id', auth()->id())->get();
        $instances = Whatsapp::where('user_id', auth()->id())->where('status', 'connected')->get();
        $templates = \App\Models\WhatsappMessage::where('user_id', auth()->id())->get();

        if ($instances->isEmpty()) {
            $instances = Whatsapp::where('user_id', auth()->id())->get();
        }

        return view('whatsapp.campaigns.create', compact('groups', 'instances', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:255',
            'whatsapp_contact_id' => 'required|exists:whatsapp_contacts,id',
            'instance_id' => 'required',
            'message_mode' => 'required|in:custom,template',
            'min_delay' => 'required|integer|min:1|max:3600',
            'max_delay' => 'required|integer|min:1|max:3600|gte:min_delay',
        ]);

        $input = $request->except('media', 'message');
        $input['user_id'] = auth()->id();
        $input['status'] = 'pending';

        // Calculate Total Numbers
        $group = WhatsappContact::withCount('numbers')->find($request->whatsapp_contact_id);
        $input['total_numbers'] = $group->numbers_count;

        // Handle Message Content based on Mode
        if ($request->message_mode === 'template') {
            $request->validate(['whatsapp_message_id' => 'required|exists:whatsapp_messages,id']);
            $template = \App\Models\WhatsappMessage::find($request->whatsapp_message_id);
            $input['message'] = $template->content;
            $input['whatsapp_message_id'] = $template->id;
        } else {
            $request->validate([
                'message' => 'required|array|min:1|max:5',
                'message.*' => 'required|string',
            ]);
            $input['message'] = $request->message;
            $input['whatsapp_message_id'] = null;
        }

        $campaign = WhatsappCampaign::create($input);

        // CREATE LOGS FOR EACH NUMBER
        $contactNumbers = \App\Models\WhatsappContactNumber::where('whatsapp_contact_id', $request->whatsapp_contact_id)->pluck('phone_number');

        $logs = [];
        foreach ($contactNumbers as $number) {
            $logs[] = [
                'whatsapp_campaign_id' => $campaign->id,
                'phone_number' => $number,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($logs, 1000) as $chunk) {
            \App\Models\WhatsappCampaignLog::insert($chunk);
        }

        return redirect()->route('whatsapp.campaigns.index')->with('success', 'تم إنشاء الحملة بنجاح، يمكنك البدء الآن.');
    }

    public function updateStatus(Request $request, $id)
    {
        $campaign = WhatsappCampaign::where('user_id', auth()->id())->findOrFail($id);

        $newStatus = $request->status;

        if (!in_array($newStatus, ['pending', 'sending', 'paused', 'completed'])) {
            return back()->with('error', 'حالة غير صالحة.');
        }

        $campaign->update(['status' => $newStatus]);

        // No queue dispatch needed — cron will pick up 'sending' campaigns automatically
        if ($newStatus == 'sending') {
            \Illuminate\Support\Facades\Log::info("Campaign #{$campaign->id} set to sending. Cron will process.");
        }

        $messages = [
            'sending' => 'تم بدء الحملة، سيتم إرسال الرسائل تلقائياً.',
            'paused' => 'تم إيقاف الحملة مؤقتاً.',
            'pending' => 'تم استئناف الحملة.',
            'completed' => 'تم إكمال الحملة.',
        ];

        $msg = $messages[$newStatus] ?? 'تم تحديث الحالة.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    public function destroy($id)
    {
        $campaign = WhatsappCampaign::where('user_id', auth()->id())->findOrFail($id);
        $campaign->delete();

        return back()->with('success', 'تم حذف الحملة بنجاح.');
    }

    public function process($id)
    {
        $campaign = WhatsappCampaign::with('contact')->where('user_id', auth()->id())->findOrFail($id);
        return view('whatsapp.campaigns.process', compact('campaign'));
    }

    /**
     * API endpoint for polling campaign progress (used by process.blade.php)
     */
    public function progress($id)
    {
        $campaign = WhatsappCampaign::where('user_id', auth()->id())->findOrFail($id);

        $recentLogs = \App\Models\WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', '!=', 'pending')
            ->latest()
            ->take(10)
            ->get(['phone_number', 'status', 'error_message', 'updated_at']);

        return response()->json([
            'status' => $campaign->status,
            'sent_count' => $campaign->sent_count,
            'failed_count' => $campaign->failed_count,
            'total_numbers' => $campaign->total_numbers,
            'recent_logs' => $recentLogs,
        ]);
    }
}

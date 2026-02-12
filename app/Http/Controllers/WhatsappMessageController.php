<?php

namespace App\Http\Controllers;

use App\Models\WhatsappMessage;
use Illuminate\Http\Request;

class WhatsappMessageController extends Controller
{
    public function index()
    {
        $messages = WhatsappMessage::where('user_id', auth()->id())->latest()->paginate(10);
        return view('whatsapp.messages.index', compact('messages'));
    }

    public function create()
    {
        return view('whatsapp.messages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|array|min:1',
            'content.*' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:10240', // 10MB
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('whatsapp_media', 'public');
        }

        // Filter out empty messages but keep keys reindexed
        $content = array_values(array_filter($request->content, function ($value) {
            return !is_null($value) && $value !== '';
        }));

        if (empty($content)) {
            return back()->withErrors(['content' => 'يجب إضافة رسالة واحدة على الأقل.']);
        }

        WhatsappMessage::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'content' => $content,
            'media_path' => $mediaPath,
        ]);

        return redirect()->route('whatsapp.messages.index')->with('success', 'تم حفظ قالب الرسائل بنجاح.');
    }

    public function edit($id)
    {
        $message = WhatsappMessage::where('user_id', auth()->id())->findOrFail($id);
        return view('whatsapp.messages.edit', compact('message'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|array|min:1',
            'content.*' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:10240',
        ]);

        $message = WhatsappMessage::where('user_id', auth()->id())->findOrFail($id);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('media')) {
            // Delete old media if exists
            if ($message->media_path && \Storage::disk('public')->exists($message->media_path)) {
                \Storage::disk('public')->delete($message->media_path);
            }
            $data['media_path'] = $request->file('media')->store('whatsapp_media', 'public');
        }

        // Filter content
        $content = array_values(array_filter($request->content, function ($value) {
            return !is_null($value) && $value !== '';
        }));

        if (empty($content)) {
            return back()->withErrors(['content' => 'يجب إضافة رسالة واحدة على الأقل.']);
        }

        $data['content'] = $content;

        $message->update($data);

        return redirect()->route('whatsapp.messages.index')->with('success', 'تم تحديث قالب الرسائل بنجاح.');
    }

    public function destroy($id)
    {
        $message = WhatsappMessage::where('user_id', auth()->id())->findOrFail($id);
        $message->delete();
        return back()->with('success', 'تم حذف القالب بنجاح.');
    }
}

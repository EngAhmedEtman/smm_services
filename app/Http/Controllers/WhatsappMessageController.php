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
            'content.*' => 'required|string',
        ]);

        WhatsappMessage::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'content' => $request->content,
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
            'content.*' => 'required|string',
        ]);

        $message = WhatsappMessage::where('user_id', auth()->id())->findOrFail($id);

        $message->update([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        return redirect()->route('whatsapp.messages.index')->with('success', 'تم تحديث قالب الرسائل بنجاح.');
    }

    public function destroy($id)
    {
        $message = WhatsappMessage::where('user_id', auth()->id())->findOrFail($id);
        $message->delete();
        return back()->with('success', 'تم حذف القالب بنجاح.');
    }
}

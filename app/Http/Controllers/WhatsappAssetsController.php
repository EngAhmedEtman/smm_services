<?php

namespace App\Http\Controllers;

use App\Models\WhatsappRandomText;
use App\Models\WhatsappWelcomeText;
use Illuminate\Http\Request;

class WhatsappAssetsController extends Controller
{
    public function index()
    {
        $randomTexts = WhatsappRandomText::where('user_id', auth()->id())->latest()->get();
        $welcomeTexts = WhatsappWelcomeText::where('user_id', auth()->id())->latest()->get();

        return view('whatsapp.assets.index', compact('randomTexts', 'welcomeTexts'));
    }

    public function storeRandom(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate(['text' => 'required|string|max:1000']);

        WhatsappRandomText::create([
            'user_id' => auth()->id(),
            'text' => $request->text,
        ]);

        return back()->with('success', 'تم إضافة النص العشوائي بنجاح.');
    }

    public function destroyRandom($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        WhatsappRandomText::findOrFail($id)->delete();
        return back()->with('success', 'تم حذف النص العشوائي.');
    }

    public function storeWelcome(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate(['text' => 'required|string|max:1000']);

        WhatsappWelcomeText::create([
            'user_id' => auth()->id(),
            'text' => $request->text,
        ]);

        return back()->with('success', 'تم إضافة رسالة الترحيب بنجاح.');
    }

    public function destroyWelcome($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        WhatsappWelcomeText::findOrFail($id)->delete();
        return back()->with('success', 'تم حذف الرسالة.');
    }
}

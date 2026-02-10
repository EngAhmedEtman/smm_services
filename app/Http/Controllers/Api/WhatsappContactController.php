<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsappContact;
use App\Models\WhatsappContactNumber;

class WhatsappContactController extends Controller
{
    public function index()
    {
        $contacts = WhatsappContact::where('user_id', auth()->id())
            ->withCount('numbers')
            ->latest()
            ->get();

        return view('whatsapp.contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('whatsapp.contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'phone_numbers' => 'required|string',
        ]);

        $contact = WhatsappContact::create([
            'user_id' => auth()->id(),
            'contact_name' => $request->contact_name,
        ]);

        $this->processNumbers($contact->id, $request->phone_numbers, $request->country_code);

        return redirect()->route('whatsapp.contacts')->with('success', 'تم إضافة المجموعة والأرقام بنجاح');
    }

    public function edit($id)
    {
        $contact = WhatsappContact::where('user_id', auth()->id())->with('numbers')->findOrFail($id);

        // Convert numbers to newline separated string for textarea
        $numbersString = $contact->numbers->pluck('phone_number')->implode("\n");

        return view('whatsapp.contact.edit', compact('contact', 'numbersString'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'phone_numbers' => 'required|string',
        ]);

        $contact = WhatsappContact::where('user_id', auth()->id())->findOrFail($id);

        $contact->update([
            'contact_name' => $request->contact_name,
        ]);

        // Sync Numbers: Delete all and re-add
        $contact->numbers()->delete();
        $this->processNumbers($contact->id, $request->phone_numbers, $request->country_code);

        return redirect()->route('whatsapp.contacts')->with('success', 'تم تحديث المجموعة بنجاح');
    }

    public function destroy($id)
    {
        $contact = WhatsappContact::where('user_id', auth()->id())->findOrFail($id);
        $contact->delete();
        return back()->with('success', 'تم الحذف بنجاح');
    }

    private function processNumbers($contactId, $input, $countryCode)
    {
        $input = str_replace(["\r\n", "\r"], "\n", $input);
        $lines = explode("\n", $input);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // NEW LOGIC: Remove + entirely
            $clean = preg_replace('/[^0-9]/', '', $line);

            // If country code provided and number doesn't start with it
            if ($countryCode && !str_starts_with($clean, $countryCode)) {
                $clean = $countryCode . $clean;
            }

            WhatsappContactNumber::create([
                'whatsapp_contact_id' => $contactId,
                'phone_number' => $clean,
            ]);
        }
    }
}

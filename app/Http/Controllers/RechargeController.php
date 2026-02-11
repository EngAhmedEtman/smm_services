<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recharge;

class RechargeController extends Controller
{
    public function create()
    {
        $recharges = Recharge::where('user_id', auth()->id())->latest()->paginate(10);
        return view('recharge', compact('recharges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);

        $input = $request->except('proof_image');
        $input['user_id'] = auth()->id();

        if ($request->hasFile('proof_image')) {
            $image = $request->file('proof_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/recharges', $imageName);
            $input['proof_image'] = 'recharges/' . $imageName;
        }

        $recharge = Recharge::create($input);

        // Notify Admin
        \App\Services\AdminNotificationService::notifyNewRecharge($recharge);

        return redirect()->route('recharge')->with('success', 'تم إرسال طلب الشحن بنجاح، سيتم مراجعته قريباً');
    }
}

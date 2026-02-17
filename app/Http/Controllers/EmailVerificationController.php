<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationCode;

class EmailVerificationController extends Controller
{

    public function index()
    {
        return view('verify.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = auth()->user();

        // Check if code matches
        if ($request->code == $user->code) {
            // Check if code is expired
            if ($user->expire_at && now()->greaterThan($user->expire_at)) {
                return back()->withErrors(['code' => 'انتهت صلاحية الكود. يرجى طلب كود جديد.']);
            }

            $user->clearVerificationCode();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['code' => 'الكود غير صحيح']);
    }

    public function resend()
    {
        $user = auth()->user();

        // Generate new code
        $user->generateVerificationCode();

        // Send email
        Mail::to($user->email)->send(new EmailVerificationCode($user->code));

        return back()->with('status', 'تم إرسال كود جديد إلى بريدك الإلكتروني');
    }
}

@extends('layouts.auth-custom')

@section('title', 'تفعيل البريد الإلكتروني')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
    <div class="max-w-md mx-auto relative z-10">
        <div class="glass rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10 w-full animate-fade-in-up">
            <div class="text-center mb-8">
                <!-- Icon -->
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>


                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">تفعيل البريد الإلكتروني</h2>
                <p class="text-gray-400 text-sm sm:text-base mt-2">تم إرسال كود التفعيل إلى بريدك الإلكتروني</p>
                <p class="text-indigo-400 font-semibold mt-1">{{ auth()->user()->email }}</p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
            <div class="bg-green-500/10 border border-green-500/50 rounded-xl p-4 mb-6 text-sm text-green-400 flex items-center gap-3 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('status') }}
            </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 rounded-xl p-4 mb-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-red-500/5 animate-pulse"></div>
                <div class="relative flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <ul class="list-disc list-inside text-sm text-red-200 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('verify.store') }}" class="space-y-6">
                @csrf

                <!-- Code Input -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-300 mb-2">كود التفعيل (6 أرقام)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="code"
                            id="code"
                            class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner text-center text-2xl tracking-widest font-mono"
                            placeholder="000000"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            value="{{ old('code') }}"
                            required
                            autofocus>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">الكود صالح لمدة 10 دقائق</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center py-3.5 sm:py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] hover:-translate-y-1">
                    تفعيل الحساب
                </button>
            </form>

            <!-- Resend Code -->
            <div class="text-center pt-4 border-t border-white/10 mt-6">
                <p class="text-sm text-gray-400 mb-3">لم تستلم الكود؟</p>
                <form method="POST" action="{{ route('verify.resend') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors hover:underline">
                        إعادة إرسال الكود
                    </button>
                </form>
            </div>

            <!-- Logout -->
            <div class="text-center pt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-400 transition-colors">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
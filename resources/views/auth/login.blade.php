@extends('layouts.auth-custom')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="glass rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10 w-full animate-fade-in-up">
    <div class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">تسجيل الدخول</h2>
        <p class="text-gray-400 text-sm sm:text-base mt-2">مرحباً بعودتك! الرجاء إدخال بياناتك للمتابعة</p>
    </div>

    <!-- Session Status -->
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

    <form method="POST" action="{{ route('login') }}" class="space-y-5 sm:space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="name@example.com" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">كلمة المرور</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input type="password" name="password" id="password" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="••••••••" required autocomplete="current-password">
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative">
                    <input id="remember_me" type="checkbox" name="remember" class="sr-only peer">
                    <div class="w-10 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                </div>
                <span class="mr-3 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">تذكرني</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors hover:underline" href="{{ route('password.request') }}">
                نسيت كلمة المرور؟
            </a>
            @endif
        </div>

        <button type="submit" class="w-full flex justify-center py-3.5 sm:py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] hover:-translate-y-1">
            تسجيل الدخول
        </button>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-400">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 hover:from-indigo-300 hover:to-purple-300 mr-1 transition-all">
                    أنشئ حساب جديد
                </a>
            </p>
        </div>
    </form>
</div>
@endsection
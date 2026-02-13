@extends('layouts.auth-custom')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20">

        <!-- Left Side: Content & Stats -->
        <div class="lg:w-1/2 text-center lg:text-right space-y-8">

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-xs font-semibold text-indigo-300 animate-fade-in-up" style="animation-delay: 0.1s;">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                </span>
                منصة التسويق رقم #1 في الشرق الأوسط
            </div>

            <!-- Hero Text -->
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight text-white leading-tight animate-fade-in-up" style="animation-delay: 0.2s;">
                شريكك الأول لنجاح <br class="hidden sm:block">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">التسويق الرقمي</span>
            </h1>

            <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto lg:mx-0 animate-fade-in-up" style="animation-delay: 0.3s;">
                نقدم أرخص وأسرع خدمات وسائل التواصل الاجتماعي. لوحة تحكم متكاملة للموزعين وأصحاب الأعمال. API قوي ودعم فني على مدار الساعة.
            </p>

            <!-- Action Buttons (Secondary) -->
            <div class="flex flex-wrap justify-center lg:justify-start gap-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                <a href="{{ route('public.services') }}" class="px-8 py-4 rounded-full glass text-white font-bold text-lg hover:bg-white/10 transition-all flex items-center gap-2 group">
                    استعراض الخدمات
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rtl:rotate-180 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 sm:gap-8 border-t border-white/10 pt-8 animate-fade-in-up" style="animation-delay: 0.5s;">
                <div class="text-center lg:text-right">
                    <p class="text-2xl sm:text-3xl font-bold text-white">5M+</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">طلب مكتمل</p>
                </div>
                <div class="text-center lg:text-right">
                    <p class="text-2xl sm:text-3xl font-bold text-white">24/7</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">دعم فني</p>
                </div>
                <div class="text-center lg:text-right">
                    <p class="text-2xl sm:text-3xl font-bold text-white">0.01$</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">يبدأ السعر من</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 max-w-md mx-auto lg:mr-auto lg:ml-0 relative z-10">
            <div class="glass rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10 w-full animate-fade-in-up" style="animation-delay: 0.2s;">
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
        </div>
    </div>

    <!-- Features Section -->
    <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        <!-- Feature 1 -->
        <div class="glass p-6 sm:p-8 rounded-2xl hover:-translate-y-2 transition-transform duration-300">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-3">تنفيذ فوري</h3>
            <p class="text-sm sm:text-base text-gray-400 leading-relaxed">نظامنا يعمل بشكل آلي بالكامل لضمان بدء تنفيذ طلباتك في غضون ثوانٍ من استلامها.</p>
        </div>

        <!-- Feature 2 -->
        <div class="glass p-6 sm:p-8 rounded-2xl hover:-translate-y-2 transition-transform duration-300">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-3">أسعار تنافسية</h3>
            <p class="text-sm sm:text-base text-gray-400 leading-relaxed">نقدم أفضل الأسعار في السوق للموزعين والأفراد، مع خصومات خاصة للكميات الكبيرة.</p>
        </div>

        <!-- Feature 3 -->
        <div class="glass p-6 sm:p-8 rounded-2xl hover:-translate-y-2 transition-transform duration-300">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-3">دعم فني متميز</h3>
            <p class="text-sm sm:text-base text-gray-400 leading-relaxed">فريق دعم فني متواجد على مدار 24 ساعة للإجابة على استفساراتكم وحل أي مشكلة قد تواجهكم.</p>
        </div>
    </div>
</div>
@endsection
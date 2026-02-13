@extends('layouts.auth-custom')

@section('title', 'إنشاء حساب جديد')

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
                انضم إلينا اليوم
            </div>

            <!-- Hero Text -->
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight text-white leading-tight animate-fade-in-up" style="animation-delay: 0.2s;">
                ابدأ رحلة نجاحك في <br class="hidden sm:block">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">عالم التسويق</span>
            </h1>

            <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto lg:mx-0 animate-fade-in-up" style="animation-delay: 0.3s;">
                أنشئ حسابك الآن واستمتع بأفضل خدمات التسويق الإلكتروني في الشرق الأوسط. سرعة، جودة، وأسعار لا تقبل المنافسة.
            </p>

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

        <!-- Right Side: Register Form -->
        <div class="w-full lg:w-1/2 max-w-md mx-auto lg:mr-auto lg:ml-0 relative z-10">
            <div class="glass rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10 w-full animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">إنشاء حساب جديد</h2>
                    <p class="text-gray-400 text-sm sm:text-base mt-2">انضم إلينا واستمتع بخدماتنا المميزة</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">الاسم الكامل</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="الاسم الكامل" :value="old('name')" required autofocus autocomplete="name">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-sm" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">رقم الهاتف</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input type="tel" name="phone" id="phone" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="01xxxxxxxxx" value="{{ old('phone') }}" required autocomplete="tel">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-400 text-sm" />
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
                            <input type="password" name="password" id="password" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="••••••••" required autocomplete="new-password">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">تأكيد كلمة المرور</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full pr-10 pl-4 py-3 sm:py-4 bg-[#0f0f13]/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="••••••••" required autocomplete="new-password">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-sm" />
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3.5 sm:py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] hover:-translate-y-1 mt-6">
                        تسجيل حساب
                    </button>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-400">
                            لديك حساب بالفعل؟
                            <a href="{{ route('login') }}" class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 hover:from-indigo-300 hover:to-purple-300 mr-1 transition-all">
                                تسجيل الدخول
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
<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EtViral | إنشاء حساب جديد</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        .glass {
            background: rgba(26, 26, 26, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hero-bg {
            background-color: #0f0f13;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 39%, 30%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339, 49%, 30%, 1) 0, transparent 50%);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px -10px rgba(79, 70, 229, 0.3);
        }
    </style>
</head>

<body class="bg-[#0f0f13] text-gray-100 antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
                            E
                        </div>
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">EtViral</span>
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8 space-x-reverse">
                        <a href="/" class="text-white hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">الرئيسية</a>
                        <a href="{{ route('public.services') }}" class="text-gray-300 hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">الخدمات</a>
                        <a href="{{ route('api.docs') }}" class="text-gray-300 hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">API</a>
                        <a href="{{ route('terms') }}" class="text-gray-300 hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">الشروط</a>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-105">تسجيل الدخول</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-24 pb-12 sm:pt-40 sm:pb-24 hero-bg min-h-screen flex items-center">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col-reverse lg:flex-row items-center gap-8 lg:gap-16">
            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-right z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass text-xs font-medium text-indigo-300 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    انضم إلينا اليوم
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                    ابدأ رحلة نجاحك في <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">عالم التسويق</span>
                </h1>
                <p class="mt-4 text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    أنشئ حسابك الآن واستمتع بأفضل خدمات التسويق الإلكتروني في الشرق الأوسط. سرعة، جودة، وأسعار لا تقبل المنافسة.
                </p>

                <!-- Stats -->
                <div class="mt-16 hidden md:grid grid-cols-3 gap-8 border-t border-white/10 pt-8">
                    <div>
                        <p class="text-3xl font-bold text-white">5M+</p>
                        <p class="text-sm text-gray-500">طلب مكتمل</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">24/7</p>
                        <p class="text-sm text-gray-500">دعم فني</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">0.01$</p>
                        <p class="text-sm text-gray-500">يبدأ السعر من</p>
                    </div>
                </div>
            </div>

            <!-- Registration Form Card (Floating) -->
            <div class="lg:w-1/2 w-full max-w-md relative">
                <!-- Decorate Blobs -->
                <div class="absolute -top-20 -left-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

                <div class="relative glass rounded-3xl p-8 shadow-2xl border border-white/10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white">إنشاء حساب جديد</h2>
                        <p class="text-gray-400 text-sm mt-2">أنشئ حسابك واستمتع بخدماتنا المميزة</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">الاسم</label>
                            <input type="text" name="name" id="name" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="الاسم الكامل" :value="old('name')" required autofocus>
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-400 text-xs" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="name@example.com" value="{{ old('email') }}" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-xs" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-1">رقم الهاتف</label>
                            <input type="tel" name="phone" id="phone" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="01xxxxxxxxx" value="{{ old('phone') }}" required>
                            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-red-400 text-xs" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-1">كلمة المرور</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="••••••••" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-xs" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all shadow-inner" placeholder="••••••••" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-400 text-xs" />
                        </div>

                        <div class="text-center pt-2">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                                لديك حساب بالفعل؟ تسجيل الدخول
                            </a>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                            تسجيل حساب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Features -->
    <div class="py-24 bg-[#0a0a0c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass p-8 rounded-2xl service-card transition-all">
                    <div class="w-14 h-14 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">تنفيذ فوري</h3>
                    <p class="text-gray-400 leading-relaxed">نظامنا يعمل بشكل آلي بالكامل لضمان بدء تنفيذ طلباتك في غضون ثوانٍ من استلامها.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass p-8 rounded-2xl service-card transition-all">
                    <div class="w-14 h-14 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">أسعار تنافسية</h3>
                    <p class="text-gray-400 leading-relaxed">نقدم أفضل الأسعار في السوق للموزعين والأفراد، مع خصومات خاصة للكميات الكبيرة.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass p-8 rounded-2xl service-card transition-all">
                    <div class="w-14 h-14 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">دعم فني متميز</h3>
                    <p class="text-gray-400 leading-relaxed">فريق دعم فني متواجد على مدار 24 ساعة للإجابة على استفساراتكم وحل أي مشكلة قد تواجهكم.</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>
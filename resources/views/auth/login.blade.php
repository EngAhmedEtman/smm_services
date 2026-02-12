<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EtViral | أفضل لوحة خدمات تواصل اجتماعي</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
                        E
                    </div>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">EtViral</span>
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
                    @auth
                    <a href="{{ url('/dashboard') }}" class="glass hover:bg-white/10 text-white px-6 py-2 rounded-full text-sm font-bold transition-all">لوحة التحكم</a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-105">حساب جديد</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 hero-bg min-h-screen flex items-center">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-16">
            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-right z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass text-xs font-medium text-indigo-300 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    منصة التسويق رقم #1 في الشرق الأوسط
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                    شريكك الأول لنجاح <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">التسويق الرقمي</span>
                </h1>
                <p class="mt-4 text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    نقدم أرخص وأسرع خدمات وسائل التواصل الاجتماعي. لوحة تحكم متكاملة للموزعين وأصحاب الأعمال. api قوي ودعم فني على مدار الساعة.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-white text-gray-900 font-bold text-lg hover:bg-gray-100 transition-all flex items-center justify-center gap-2 shadow-xl shadow-white/10">
                        تسجيل حساب جديد
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('public.services') }}" class="px-8 py-4 rounded-full glass text-white font-bold text-lg hover:bg-white/5 transition-all">
                        استعراض الخدمات
                    </a>
                </div>

                <!-- Stats -->
                <div class="mt-16 grid grid-cols-3 gap-8 border-t border-white/10 pt-8">
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

            <!-- Login Form Card (Floating) -->
            <div class="lg:w-1/2 w-full max-w-md relative">
                <!-- Decorate Blobs -->
                <div class="absolute -top-20 -left-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

                <div class="relative glass rounded-3xl p-8 shadow-2xl border border-white/10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white">تسجيل الدخول</h2>
                        <p class="text-gray-400 text-sm mt-2">مرحباً بعودتك! الرجاء إدخال بياناتك</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all" placeholder="name@example.com" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">كلمة المرور</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-3 bg-[#0f0f13] border border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white placeholder-gray-500 transition-all" placeholder="••••••••" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-700 bg-[#0f0f13] rounded">
                                <label for="remember-me" class="mr-2 block text-sm text-gray-400">تذكرني</label>
                            </div>
                            <div class="text-sm">
                                <a href="#" class="font-medium text-indigo-400 hover:text-indigo-300">نسيت كلمة المرور؟</a>
                            </div>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                            دخول
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->


    <!-- Features -->
    <div class="py-24 bg-[#0f0f13]">
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
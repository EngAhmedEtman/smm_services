<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EtViral')</title>
    <meta name="description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع المنصات: فيسبوك، انستجرام، تويتر، سناب شات، تيك توك، يوتيوب، واتساب، تليجرام، لينكد إن. نساعدك في تعزيز ظهورك الرقمي وزيادة المبيعات.')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'EtViral')">
    <meta property="og:description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع المنصات: فيسبوك، انستجرام، تويتر، سناب شات، تيك توك، يوتيوب، واتساب، تليجرام، لينكد إن. نساعدك في تعزيز ظهورك الرقمي وزيادة المبيعات.')">
    <meta property="og:image" content="{{ asset('images/logo/logo-orange.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'EtViral')">
    <meta property="twitter:description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع المنصات: فيسبوك، انستجرام، تويتر، سناب شات، تيك توك، يوتيوب، واتساب، تليجرام، لينكد إن. نساعدك في تعزيز ظهورك الرقمي وزيادة المبيعات.')">
    <meta property="twitter:image" content="{{ asset('images/logo/logo-orange.png') }}">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="@yield('title', 'EtViral')">
    <meta itemprop="description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع المنصات: فيسبوك، انستجرام، تويتر، سناب شات، تيك توك، يوتيوب، واتساب، تليجرام، لينكد إن. نساعدك في تعزيز ظهورك الرقمي وزيادة المبيعات.')">
    <meta itemprop="image" content="{{ asset('images/logo/logo-orange.png') }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-orange.png') }}">
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
    </style>
    @stack('styles')
</head>

<body class="bg-[#0f0f13] text-gray-100 antialiased overflow-x-hidden flex flex-col min-h-screen">

    <!-- Navbar -->
    @if(auth()->check() || !($hideHeaderFooter ?? false))
    <nav class="fixed w-full z-50 transition-all duration-300 glass border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-12 h-12 transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                            <img src="{{ asset('images/logo/logo-icon.png') }}" alt="EtViral" class="w-full h-full object-contain" style="filter: brightness(0) saturate(100%) invert(50%) sepia(91%) saturate(2090%) hue-rotate(358deg) brightness(97%) contrast(93%);">
                        </div>
                        <span class="text-2xl font-bold tracking-wide"><span style="color: #7eaeff;">Et</span><span style="color: #F37021;">Viral</span></span>
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
    @endif

    <!-- Main Content -->
    <main class="flex-grow pt-32 pb-12 hero-bg">
        @yield('content')
    </main>

    <!-- Footer -->
    @if(auth()->check() || !($hideHeaderFooter ?? false))
    @include('layouts.footer')
    @endif

    @stack('scripts')
</body>

</html>
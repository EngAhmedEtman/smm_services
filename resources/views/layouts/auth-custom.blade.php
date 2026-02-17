<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EtViral | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-orange.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
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
            min-height: 100vh;
            width: 100%;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .glass {
                background: rgba(26, 26, 26, 0.85);
                /* Slightly more opaque on mobile for readability */
                backdrop-filter: blur(16px);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
    </style>
</head>

<body class="bg-[#0f0f13] text-gray-100 antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Navbar (Simplified for Auth) -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                            <img src="{{ asset('images/logo/logo-icon.png') }}" alt="EtViral" class="w-full h-full object-contain" style="filter: brightness(0) saturate(100%) invert(50%) sepia(91%) saturate(2090%) hue-rotate(358deg) brightness(97%) contrast(93%);">
                        </div>
                        <span class="text-xl sm:text-2xl font-bold tracking-wide"><span style="color: #7eaeff;">Et</span><span style="color: #F37021;">Viral</span></span>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-white hover:text-indigo-400 transition-colors">لوحة الدشبورد</a>
                    @else
                    @if (Route::currentRouteName() == 'register')
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">تسجيل الدخول</a>
                    @elseif (Route::currentRouteName() == 'login')
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">إنشاء حساب</a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="hero-bg min-h-screen relative overflow-x-hidden pt-20">

        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[20%] left-[10%] w-64 h-64 sm:w-96 sm:h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-[20%] right-[10%] w-64 h-64 sm:w-96 sm:h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[20%] left-[20%] w-64 h-64 sm:w-96 sm:h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 w-full h-full">
            @yield('content')
        </div>
    </main>

</body>

</html>
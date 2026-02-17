<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EtViral'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-orange.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #0f0f13;
            color: #f3f4f6;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a2e;
        }

        ::-webkit-scrollbar-thumb {
            background: #4a4a6a;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6a6a8a;
        }

        .glass {
            background: rgba(30, 30, 35, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen bg-[#0f0f13]">
    <div class="min-h-screen flex flex-col bg-[#0f0f13]">

        <!-- Guest Header -->
        <header class="bg-[#12121a] border-b border-gray-800/50 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                            <img src="{{ asset('images/logo/logo-icon.png') }}" alt="EtViral" class="w-full h-full object-contain" style="filter: brightness(0) saturate(100%) invert(50%) sepia(91%) saturate(2090%) hue-rotate(358deg) brightness(97%) contrast(93%);">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold tracking-wide"><span style="color: #7eaeff;">Et</span><span style="color: #F37021;">Viral</span></h1>
                            <p class="text-xs text-gray-500">Viral Growth Starts Here</p>
                        </div>
                    </a>

                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-gray-300 hover:text-white transition-colors font-semibold text-sm">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition-all text-sm">
                            إنشاء حساب
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
            @yield('content')
        </main>

        <!-- Guest Footer -->
        <footer class="bg-[#12121a] border-t border-gray-800/50 mt-auto">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">© {{ date('Y') }} <span class="font-bold"><span style="color: #7eaeff;">Et</span><span style="color: #F37021;">Viral</span></span>. جميع الحقوق محفوظة</p>
                    <div class="flex gap-6">
                        <a href="#" class="text-gray-500 hover:text-white transition-colors text-sm">سياسة الخصوصية</a>
                        <a href="#" class="text-gray-500 hover:text-white transition-colors text-sm">الشروط والأحكام</a>
                        <a href="#" class="text-gray-500 hover:text-white transition-colors text-sm">الدعم الفني</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>
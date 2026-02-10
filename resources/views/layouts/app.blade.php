<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Etman SMM'))</title>

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
            /* Custom Dark BG */
            color: #f3f4f6;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #16161a;
        }

        ::-webkit-scrollbar-thumb {
            background: #2d2d33;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #4f4f55;
        }

        .glass {
            background: rgba(30, 30, 35, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .form-input {
            background-color: #16161a;
            border: 1px solid #2d2d33;
            color: white;
        }

        .form-input:focus {
            border-color: #6366f1;
            outline: none;
            ring: 2px solid rgba(99, 102, 241, 0.5);
        }

        /* Toast Animation */
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen bg-[#0f0f13]">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="md:mr-64 transition-all duration-300 min-h-screen flex flex-col">

        <!-- Header -->
        @include('layouts.header')

        <!-- Page Content -->
        <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    @stack('scripts')
</body>

</html>
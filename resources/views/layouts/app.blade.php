<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Etman SMM'))</title>
    <meta name="description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع منصات التواصل الاجتماعي: فيسبوك، واتساب، انستجرام، تيك توك، يوتيوب، وغيرها. نساعدك في تعزيز ظهورك الرقمي وزيادة مبيعاتك.')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'Etman SMM'))">
    <meta property="og:description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع منصات التواصل الاجتماعي: فيسبوك، واتساب، انستجرام، تيك توك، يوتيوب، وغيرها. نساعدك في تعزيز ظهورك الرقمي وزيادة مبيعاتك.')">
    <meta property="og:image" content="{{ asset('images/logo/logo-orange.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', config('app.name', 'Etman SMM'))">
    <meta property="twitter:description" content="@yield('description', 'خدمات تسويق إلكتروني متكاملة لجميع منصات التواصل الاجتماعي: فيسبوك، واتساب، انستجرام، تيك توك، يوتيوب، وغيرها. نساعدك في تعزيز ظهورك الرقمي وزيادة مبيعاتك.')">
    <meta property="twitter:image" content="{{ asset('images/logo/logo-orange.png') }}">

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

        /* Autofill Fix for Dark Mode */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #16161a inset !important;
            -webkit-text-fill-color: white !important;
            caret-color: white !important;
            background-color: #16161a !important;
        }

        /* Consistent Form Input Styles */
        .form-input {
            background-color: #16161a;
            border: 1px solid #2d2d33;
            color: white;
            transition: all 0.2s ease-in-out;
        }

        .form-input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
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

        /* Hide Scrollbar */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen bg-[#0f0f13]" x-data="{ mobileSidebarOpen: false }">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="md:mr-64 transition-all duration-300 min-h-screen flex flex-col">

        <!-- Header -->
        @include('layouts.header')

        <!-- Page Content -->
        <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    @stack('scripts')

    @stack('scripts')

    <!-- Global Notifications (Vanilla JS Fallback) -->
    <div id="global-notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('global-notification-container');

            window.addEventListener('notification', (event) => {
                const {
                    type,
                    message,
                    title
                } = event.detail;
                showGlobalNotification(message, type, title);
            });

            // Expose globally just in case
            window.showGlobalNotification = (message, type = 'info', title = '') => {
                const toast = document.createElement('div');

                // Styles based on type
                let bg = '#1e1e24';
                let border = '#4f46e5';
                let text = '#fff';

                if (type === 'success') {
                    bg = '#064e3b';
                    border = '#10b981';
                    text = '#d1fae5';
                }
                if (type === 'error') {
                    bg = '#7f1d1d';
                    border = '#ef4444';
                    text = '#fee2e2';
                }
                if (type === 'warning') {
                    bg = '#78350f';
                    border = '#f59e0b';
                    text = '#fef3c7';
                }

                toast.style.cssText = `
                    background: ${bg};
                    border-left: 5px solid ${border};
                    color: ${text};
                    padding: 16px;
                    border-radius: 8px;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
                    min-width: 300px;
                    max-width: 400px;
                    font-family: inherit;
                    pointer-events: auto;
                    opacity: 0;
                    transform: translateX(100%);
                    transition: all 0.3s ease-out;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                `;

                const iconHtml = type === 'success' ? '✔' : (type === 'error' ? '✖' : 'ℹ');

                toast.innerHTML = `
                    <div style="font-size: 20px; font-weight: bold;">${iconHtml}</div>
                    <div>
                        <div style="font-weight: bold; margin-bottom: 4px;">${title || (type === 'error' ? 'Error' : 'Notification')}</div>
                        <div style="font-size: 14px; opacity: 0.9;">${message}</div>
                    </div>
                `;

                container.appendChild(toast);

                // Animate In
                requestAnimationFrame(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateX(0)';
                });

                // Auto Remove
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            };

            // Handle Session Flashes
            @if(session('success'))
            showGlobalNotification(@json(session('success')), 'success', 'تمت العملية بنجاح');
            @endif

            @if(session('error'))
            showGlobalNotification(@json(session('error')), 'error', 'خطأ');
            @endif

            @if($errors - > any())
            showGlobalNotification('يرجى مراجعة البيانات المدخلة', 'error', 'خطأ في البيانات');
            @endif
        });
    </script>


</body>

</html>
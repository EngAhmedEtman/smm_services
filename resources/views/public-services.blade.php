@extends('layouts.public')

@section('title', 'EtViral | خدماتنا')

@section('content')
<!-- Header -->
<div class="text-center px-4 mb-20">
    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">خدماتنا المميزة</h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto">نقدم مجموعة متكاملة من الخدمات الرقمية التي تساعدك على النمو والانتشار.</p>
</div>

<!-- Services Highlights -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

        <!-- Social Media Marketing -->
        <div class="glass rounded-3xl p-8 hover:bg-white/5 transition-all duration-500 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>

            <div class="w-16 h-16 rounded-2xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-white mb-4">خدمات السوشيال ميديا</h2>
            <p class="text-gray-400 mb-6 leading-relaxed">
                عزز تواجدك الرقمي على جميع منصات التواصل الاجتماعي (Facebook, Instagram, Twitter, TikTok, YouTube). نقدم خدمات زيادة المتابعين، الإعجابات، المشاهدات، والتفاعل الحقيقي بأسعار تنافسية وتنفيذ فوري.
            </p>

            <ul class="space-y-3 mb-8">
                <li class="flex items-center gap-3 text-gray-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    زيادة المتابعين بجودة عالية
                </li>
                <li class="flex items-center gap-3 text-gray-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    تفاعل وإعجابات فورية
                </li>
                <li class="flex items-center gap-3 text-gray-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    مشاهدات حقيقية للفيديوهات
                </li>
            </ul>

            <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all transform hover:translate-y-[-2px]">
                ابدأ الآن
            </a>
        </div>

        <!-- WhatsApp Marketing -->
        <div class="glass rounded-3xl p-8 hover:bg-white/5 transition-all duration-500 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>

            <div class="w-16 h-16 rounded-2xl bg-green-500/20 flex items-center justify-center text-green-400 mb-6 group-hover:scale-110 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-white mb-4">التسويق عبر واتساب</h2>
            <p class="text-gray-400 mb-6 leading-relaxed">
                منصة متكاملة لإدارة حملاتك التسويقية عبر واتساب. أرسل رسائل جماعية، قم بجدولة الحملات، وأدر جهات اتصالك بسهولة. حل مثالي للوصول إلى عملائك بشكل مباشر وفعال.
            </p>

            <ul class="space-y-3 mb-8">
                <li class="flex items-center gap-3 text-gray-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    إرسال رسائل جماعية بلا حدود
                </li>
                <li class="flex items-center gap-3 text-gray-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    ربط واجهة برمجية (API) قوية
                </li>
                <li class="flex items-center gap-3 text-gray-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    تقارير مفصلة للحملات
                </li>
            </ul>

            <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all transform hover:translate-y-[-2px]">
                جرب الآن
            </a>
        </div>

    </div>
</div>
@endsection
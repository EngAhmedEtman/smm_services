@extends('layouts.app')

@section('content')
<style>
    .package-card {
        transition: all 0.3s ease;
    }

    .package-card:hover {
        transform: translateY(-10px);
    }

    .popular-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
</style>

<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-white mb-4">باقات WhatsApp API</h1>
        <p class="text-xl text-white/80 mb-6">اختر الباقة المناسبة لاحتياجاتك وابدأ في إرسال رسائل WhatsApp بسهولة</p>
        @guest
        <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition-all shadow-lg">
                تسجيل الدخول
            </a>
            <a href="{{ route('register') }}" class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-lg font-semibold hover:shadow-xl transition-all">
                إنشاء حساب جديد
            </a>
        </div>
        @endguest
    </div>

    <!-- Packages Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
        @forelse($packages as $index => $package)
        <div class="package-card bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-gray-700 {{ $index === 1 ? 'ring-4 ring-yellow-400' : '' }}">

            @if($index === 1)
            <div class="popular-badge text-center py-2">
                <span class="text-white font-bold text-sm">⭐ الأكثر شعبية</span>
            </div>
            @endif

            <div class="p-8">
                <h3 class="text-2xl font-bold text-white mb-2">{{ $package->name }}</h3>

                <div class="mb-6">
                    <span class="text-5xl font-bold text-pink-400">{{ number_format($package->price, 0) }}</span>
                    <span class="text-gray-400 text-lg">ج.م</span>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-300"><strong class="text-white">{{ number_format($package->message_limit) }}</strong> رسالة</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-300">صلاحية <strong class="text-white">{{ $package->duration_days }}</strong> يوم</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-300">Rollover تلقائي</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-300">إشعارات تلقائية</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-300">دعم فني 24/7</span>
                    </li>
                </ul>

                @auth
                <a href="{{ route('packages.index') }}"
                    class="block w-full text-center px-6 py-3 {{ $index === 1 ? 'bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700' : 'bg-gray-700 hover:bg-gray-600' }} text-white rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl">
                    اشترك الآن
                </a>
                @else
                <a href="{{ route('register') }}"
                    class="block w-full text-center px-6 py-3 {{ $index === 1 ? 'bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700' : 'bg-gray-700 hover:bg-gray-600' }} text-white rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl">
                    اشترك الآن
                </a>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20">
            <div class="bg-gray-800/50 rounded-2xl p-12 max-w-md mx-auto border border-gray-700">
                <svg class="w-24 h-24 mx-auto text-gray-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="text-2xl font-bold text-white mb-2">قريباً</h3>
                <p class="text-gray-400">سيتم إضافة الباقات قريباً</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Features Section -->
    <div class="mt-20 text-center">
        <h2 class="text-3xl font-bold text-white mb-12">لماذا تختار خدمتنا؟</h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="bg-gray-800/50 rounded-xl p-8 border border-gray-700">
                <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">سرعة فائقة</h3>
                <p class="text-gray-400">إرسال رسائل WhatsApp بسرعة كبيرة وموثوقية عالية</p>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-8 border border-gray-700">
                <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">آمن ومضمون</h3>
                <p class="text-gray-400">حماية كاملة لبياناتك ورسائلك</p>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-8 border border-gray-700">
                <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">دعم فني متواصل</h3>
                <p class="text-gray-400">فريق دعم جاهز لمساعدتك على مدار الساعة</p>
            </div>
        </div>
    </div>
</div>
@endsection
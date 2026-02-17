@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', 'باقات WhatsApp API')
@section('header_title', 'باقات WhatsApp API')

@section('content')
<div class="space-y-6">

    {{-- Page Title --}}
    <div class="glass p-6 rounded-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <svg class="w-7 h-7 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                باقات WhatsApp API
            </h1>
            <p class="text-gray-400 mt-1">اختر الباقة المناسبة لاحتياجاتك وابدأ في إرسال الرسائل فوراً</p>
        </div>
        @guest
        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-bold transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            تسجيل الدخول
        </a>
        @endguest
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="glass p-4 rounded-2xl border border-green-500/30 flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <p class="text-green-300 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="glass p-4 rounded-2xl border border-red-500/30 flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-red-300 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Current Subscription (Auth Only) --}}
    @auth
    @if($apiClient && $apiClient->hasActivePackage())
    <div class="glass p-6 rounded-2xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                باقتك الحالية: {{ $apiClient->package_name }}
            </h2>
            <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">نشطة</span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="col-span-2">
                <div class="mb-2 flex justify-between text-sm">
                    <span class="text-gray-400">الرصيد المتبقي</span>
                    <span class="text-white font-semibold">{{ number_format($apiClient->balance) }} رسالة</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 h-4 rounded-full transition-all duration-500" style="width: 70%"></div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-xl p-4 border border-purple-500/20">
                <p class="text-sm text-gray-400 mb-1">ينتهي في</p>
                <h3 class="text-2xl font-bold text-white mb-1">{{ $apiClient->expire_at->diffInDays(now()) }}</h3>
                <p class="text-xs text-gray-400">يوم متبقي</p>
                <p class="text-xs text-gray-500 mt-1">{{ $apiClient->expire_at->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>
    @endif
    @endauth

    {{-- Packages Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($packages as $index => $package)
        <div class="glass p-6 rounded-2xl relative overflow-hidden group hover:ring-2 hover:ring-indigo-500/50 transition-all duration-300">
            {{-- Decorative blob --}}
            <div class="absolute -right-6 -top-6 w-24 h-24 {{ $index === 0 ? 'bg-indigo-500/10' : ($index === 1 ? 'bg-purple-500/10' : 'bg-pink-500/10') }} rounded-full group-hover:{{ $index === 0 ? 'bg-indigo-500/20' : ($index === 1 ? 'bg-purple-500/20' : 'bg-pink-500/20') }} transition-all duration-500"></div>

            {{-- Popular Badge --}}
            @if($index === 1)
            <div class="absolute top-4 left-4">
                <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                    ⭐ الأكثر طلباً
                </span>
            </div>
            @endif

            <div class="relative">
                {{-- Package Name --}}
                <p class="text-sm font-medium text-gray-400 mb-1">{{ $package->name }}</p>

                {{-- Price --}}
                <h3 class="text-3xl font-bold text-white">{{ number_format($package->price, 0) }} <span class="text-lg text-gray-400 font-normal">ج.م</span></h3>

                {{-- Features --}}
                <div class="mt-6 space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-6 h-6 rounded-full bg-green-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300"><strong class="text-white">{{ number_format($package->message_limit) }}</strong> رسالة</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-6 h-6 rounded-full bg-indigo-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300">صلاحية <strong class="text-white">{{ $package->duration_days }}</strong> يوم</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-6 h-6 rounded-full bg-purple-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300">ترحيل الرصيد (Rollover)</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-6 h-6 rounded-full bg-teal-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-300">إشعارات تلقائية</span>
                    </div>
                </div>

                {{-- Subscribe Button --}}
                <div class="mt-6">
                    @auth
                    <form action="{{ route('packages.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        <button type="submit" class="w-full {{ $index === 1 ? 'bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700' : 'bg-indigo-600 hover:bg-indigo-700' }} text-white px-6 py-3 rounded-lg font-bold transition-all text-center">
                            اشترك الآن
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="block w-full {{ $index === 1 ? 'bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700' : 'bg-indigo-600 hover:bg-indigo-700' }} text-white px-6 py-3 rounded-lg font-bold transition-all text-center">
                        سجل للاشتراك
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full glass p-6 rounded-2xl text-center">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-xl font-bold text-white mb-2">لا توجد باقات متاحة</h3>
            <p class="text-gray-400">سيتم إضافة الباقات قريباً</p>
        </div>
        @endforelse
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:bg-green-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">التفعيل</p>
                <h3 class="text-xl font-bold text-white">فوري</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-green-400 bg-green-500/10 w-fit px-2 py-1 rounded-full">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    بدون انتظار
                </div>
            </div>
        </div>

        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:bg-indigo-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">ترحيل الرصيد</p>
                <h3 class="text-xl font-bold text-white">تلقائي</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-indigo-400 bg-indigo-500/10 w-fit px-2 py-1 rounded-full">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    عند التجديد
                </div>
            </div>
        </div>

        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full group-hover:bg-purple-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">الإشعارات</p>
                <h3 class="text-xl font-bold text-white">ذكية</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-purple-400 bg-purple-500/10 w-fit px-2 py-1 rounded-full">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    عند انخفاض الرصيد
                </div>
            </div>
        </div>

        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-pink-500/10 rounded-full group-hover:bg-pink-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">الدعم الفني</p>
                <h3 class="text-xl font-bold text-white">24/7</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-pink-400 bg-pink-500/10 w-fit px-2 py-1 rounded-full">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    متاح دائماً
                </div>
            </div>
        </div>
    </div>

    {{-- Important Info --}}
    <div class="glass p-6 rounded-2xl border border-indigo-500/20">
        <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            معلومات مهمة
        </h3>
        <ul class="space-y-2 text-gray-300 text-sm">
            <li class="flex items-start gap-2"><span class="text-indigo-400 mt-0.5">•</span> عند تجديد الباقة، الرصيد المتبقي يترحّل للباقة الجديدة تلقائياً.</li>
            <li class="flex items-start gap-2"><span class="text-indigo-400 mt-0.5">•</span> ستصلك إشعارات عند انخفاض الرصيد أو قرب انتهاء الباقة.</li>
            <li class="flex items-start gap-2"><span class="text-indigo-400 mt-0.5">•</span> السعر يُخصم من رصيدك الحالي في المنصة.</li>
            @guest
            <li class="flex items-start gap-2"><span class="text-pink-400 mt-0.5">•</span> <strong class="text-white">يجب تسجيل الدخول أولاً للاشتراك في الباقات.</strong></li>
            @endguest
        </ul>
    </div>
</div>
@endsection
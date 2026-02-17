@extends('layouts.app')

@section('title', 'لوحة التحكم | EtViral')
@section('header_title', 'لوحة التحكم')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section (Breeze Integration) -->
    <div class="glass p-6 rounded-2xl mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">مرحباً بك، {{ Auth::user()->name ?? 'ضيف' }}!</h1>
            <p class="text-gray-400 mt-1">
                عضو منذ {{ Auth::user()->created_at->diffForHumans() }}
            </p>
        </div>
        <a href="{{ route('addOrder') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-bold transition-colors">
            + طلب جديد
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Balance Card -->
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:bg-indigo-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">الرصيد الحالي</p>
                <h3 class="text-3xl font-bold text-white">{{ number_format(auth()->user()->balance ?? 0, 2) }} ج.م</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-green-400 bg-green-500/10 w-fit px-2 py-1 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    + 10.00 ج.م هذا الأسبوع
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full group-hover:bg-purple-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">إجمالي الطلبات</p>
                <h3 class="text-3xl font-bold text-white">{{ auth()->user()->orders()->count() }}</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-indigo-400 bg-indigo-500/10 w-fit px-2 py-1 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    الطلبات النشطة :
                    {{ auth()->user()->orders()->whereIn('status', ['pending', 'processing', 'in_progress'])->count() }}
                </div>
            </div>
        </div>

        <!-- Spending Card -->
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-pink-500/10 rounded-full group-hover:bg-pink-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">إجمالي الإنفاق</p>
                <h3 class="text-3xl font-bold text-white">{{ number_format(auth()->user()->total_spent ?? 0, 2) }} ج.م</h3>
                <div class="mt-4 text-xs text-gray-500">
                    منذ بداية التسجيل
                </div>
            </div>
        </div>

        <!-- Total Messages Sent Card -->
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:bg-green-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">رسائل واتساب المرسلة</p>
                <h3 class="text-3xl font-bold text-white">{{ number_format($totalMessagesSent ?? 0) }}</h3>
                <div class="mt-4 flex items-center gap-2 text-xs text-green-400 bg-green-500/10 w-fit px-2 py-1 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    تم الإرسال بنجاح
                </div>
            </div>
        </div>

        <!-- WhatsApp Connected Card -->
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-teal-500/10 rounded-full group-hover:bg-teal-500/20 transition-all duration-500"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-400 mb-1">أرقام واتساب المتصلة</p>
                <h3 class="text-3xl font-bold text-white">{{ $whatsappConnectedCount ?? 0 }}</h3>
                <div class="mt-4 flex items-center gap-2 text-xs {{ ($whatsappConnectedCount ?? 0) > 0 ? 'text-teal-400 bg-teal-500/10' : 'text-gray-400 bg-gray-500/10' }} w-fit px-2 py-1 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ ($whatsappConnectedCount ?? 0) > 0 ? 'نشط حالياً' : 'غير متصل' }}
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Package Subscription Card -->
    @if($subscriptionData)
    <div class="glass p-6 rounded-2xl mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                باقتك الحالية: {{ $subscriptionData['package_name'] }}
            </h2>
            <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">
                {{ $subscriptionData['status'] === 'active' ? 'نشطة' : 'منتهية' }}
            </span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Balance Progress -->
            <div class="col-span-2">
                <div class="mb-2 flex justify-between text-sm">
                    <span class="text-gray-400">الرسائل المستخدمة</span>
                    <span class="text-white font-semibold">{{ number_format($subscriptionData['total_messages'] - $subscriptionData['balance']) }} / {{ number_format($subscriptionData['total_messages']) }}</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 h-4 rounded-full transition-all duration-500"
                        style="width: {{ $subscriptionData['usage_percentage'] }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">
                    متبقي: <strong class="text-white">{{ number_format($subscriptionData['balance']) }}</strong> رسالة
                    ({{ 100 - $subscriptionData['usage_percentage'] }}%)
                </p>
            </div>

            <!-- Days Left -->
            <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-xl p-4 border border-purple-500/20">
                <p class="text-sm text-gray-400 mb-1">صلاحية الباقة</p>
                <h3 class="text-3xl font-bold text-white mb-1">{{ max(0, $subscriptionData['days_left']) }}</h3>
                <p class="text-xs text-gray-400">
                    @if($subscriptionData['days_left'] > 0)
                    يوم متبقي
                    @else
                    منتهية
                    @endif
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    تنتهي في: {{ $subscriptionData['expire_at']->format('Y-m-d') }}
                </p>
            </div>
        </div>

        <div class="mt-4 flex gap-4">
            <a href="{{ route('packages.index') }}"
                class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all text-center">
                تجديد / ترقية الباقة
            </a>
            @if($subscriptionData['usage_percentage'] >= 90)
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                رصيد منخفض!
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="glass p-6 rounded-2xl mt-6 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-xl font-bold text-white mb-2">لا توجد باقة نشطة</h3>
        <p class="text-gray-400 mb-4">اشترك في إحدى باقات WhatsApp API للبدء في إرسال الرسائل</p>
        <a href="{{ route('packages.index') }}"
            class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all">
            عرض الباقات المتاحة
        </a>
    </div>
    @endif

</div>
@endsection
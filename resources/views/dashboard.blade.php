@extends('layouts.app')

@section('title', 'لوحة التحكم | EtViral')
@section('header_title', 'لوحة التحكم')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section (Breeze Integration) -->
    <div class="glass p-6 rounded-2xl mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">مرحباً بك، {{ Auth::user()->name ?? 'ضيف' }}!</h1>
            <p class="text-gray-400 mt-1">إليك نظرة عامة على نشاط حسابك اليوم.</p>
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
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'الملف الشخصي | Etman SMM')
@section('header_title', 'الملف الشخصي')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ activeTab: '{{ request('tab') == 'settings' ? 'settings' : 'overview' }}' }">

    <!-- User Header Card -->
    <div class="glass rounded-2xl p-6 md:p-8 mb-8 flex flex-col md:flex-row items-center gap-6 md:gap-8 shadow-2xl">
        <div class="relative group">
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full p-1 bg-gradient-to-br from-indigo-500 to-purple-600 shadow-2xl transform group-hover:scale-105 transition-transform duration-300">
                <div class="w-full h-full rounded-full bg-[#1e1e24] flex items-center justify-center overflow-hidden">
                    @if($user->avatar ?? false)
                    <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
                    @else
                    <span class="text-4xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-1 right-1 w-6 h-6 md:w-8 md:h-8 bg-green-500 rounded-full border-4 border-[#0f0f13] flex items-center justify-center" title="Active">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <div class="flex-1 text-center md:text-right space-y-2">
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">{{ $user->name }}</h1>
                <p class="text-gray-400 font-mono text-sm">{{ $user->email }}</p>
            </div>
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-4">
                <span class="px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold uppercase tracking-wider">
                    ID: #{{ $user->id }}
                </span>
                <span class="px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    عضو مميز
                </span>
            </div>
        </div>

        <div class="flex flex-col gap-3 min-w-[200px]">
            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700 text-center shadow-inner">
                <p class="text-xs text-gray-400 mb-1">الرصيد الحالي</p>
                <p class="text-3xl font-bold text-green-400 flex items-center justify-center gap-1 font-mono">
                    <span class="text-lg text-green-600">$</span>{{ number_format($user->balance ?? 0, 2) }}
                </p>
            </div>
            <a href="#" class="w-full py-2 rounded-lg bg-green-600 hover:bg-green-700 text-sm text-white transition-colors flex items-center justify-center gap-2 shadow-lg shadow-green-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                شحن الرصيد
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex gap-4 mb-8 border-b border-gray-800 overflow-x-auto pb-2 scrollbar-hide">
        <button @click="activeTab = 'overview'"
            :class="activeTab === 'overview' ? 'text-indigo-400 border-indigo-500 bg-indigo-500/10' : 'text-gray-400 border-transparent hover:text-gray-200 hover:bg-gray-800/50'"
            class="px-6 py-3 rounded-t-lg font-bold border-b-2 transition-all whitespace-nowrap flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            نظرة عامة
        </button>
        <button @click="activeTab = 'settings'"
            :class="activeTab === 'settings' ? 'text-indigo-400 border-indigo-500 bg-indigo-500/10' : 'text-gray-400 border-transparent hover:text-gray-200 hover:bg-gray-800/50'"
            class="px-6 py-3 rounded-t-lg font-bold border-b-2 transition-all whitespace-nowrap flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            إعدادات الحساب
        </button>
    </div>

    <!-- Overview Tab Content -->
    <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="glass p-6 rounded-2xl flex flex-col gap-2 relative overflow-hidden group hover:bg-white/5 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-colors"></div>
                <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400 mb-2 relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <p class="text-gray-400 text-sm relative z-10">إجمالي الطلبات</p>
                <p class="text-3xl font-bold text-white relative z-10">{{ $stats['total_orders'] }}</p>
            </div>

            <div class="glass p-6 rounded-2xl flex flex-col gap-2 relative overflow-hidden group hover:bg-white/5 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-colors"></div>
                <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center text-green-400 mb-2 relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-400 text-sm relative z-10">الطلبات المكتملة</p>
                <p class="text-3xl font-bold text-white relative z-10">{{ $stats['completed_orders'] }}</p>
            </div>

            <div class="glass p-6 rounded-2xl flex flex-col gap-2 relative overflow-hidden group hover:bg-white/5 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl group-hover:bg-yellow-500/20 transition-colors"></div>
                <div class="w-10 h-10 rounded-lg bg-yellow-500/20 flex items-center justify-center text-yellow-400 mb-2 relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-400 text-sm relative z-10">قيد التنفيذ</p>
                <p class="text-3xl font-bold text-white relative z-10">{{ $stats['pending_orders'] }}</p>
            </div>

            <div class="glass p-6 rounded-2xl flex flex-col gap-2 relative overflow-hidden group hover:bg-white/5 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-colors"></div>
                <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 mb-2 relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-400 text-sm relative z-10">إجمالي المصروفات</p>
                <p class="text-3xl font-bold text-white relative z-10 font-mono">${{ number_format($stats['total_spent'], 2) }}</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="glass p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        نشاط الطلبات (Static)
                    </h3>
                    <select class="bg-gray-800 border-none text-xs text-gray-400 rounded-lg focus:ring-0">
                        <option>آخر 7 أيام</option>
                    </select>
                </div>
                <!-- CSS Only Bar Chart -->
                <div class="flex items-end justify-between h-56 gap-3 pb-2">
                    @foreach([35, 60, 25, 80, 50, 95, 70] as $h)
                    <div class="w-full bg-indigo-500/10 rounded-t-lg relative group h-full flex flex-col justify-end hover:bg-indigo-500/20 transition-colors cursor-pointer">
                        <div style="height: {{ $h }}%;" class="w-full bg-indigo-500 rounded-t-lg relative transition-all duration-500 ease-out group-hover:bg-indigo-400">
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-900 text-white font-bold text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 shadow-xl border border-gray-700">
                                {{ $h }}
                                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between text-xs text-gray-400 mt-2 font-mono uppercase">
                    <span>Sat</span><span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span>
                </div>
            </div>

            <div class="glass p-6 rounded-2xl">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    توزيع الخدمات (Static)
                </h3>
                <div class="flex items-center justify-center lg:justify-start gap-8">
                    <!-- Pie Chart Circle -->
                    <div class="relative w-48 h-48 rounded-full border-[16px] border-indigo-500/10 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- In a real app, use JS to calculate stroke-dasharray -->
                            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#6366f1" stroke-width="10" stroke-dasharray="180 251" class="drop-shadow-[0_0_10px_rgba(99,102,241,0.5)]" />
                            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#10b981" stroke-width="10" stroke-dasharray="50 251" stroke-dashoffset="-180" />
                        </svg>
                        <div class="absolute text-center">
                            <span class="block text-3xl font-bold text-white">Top</span>
                            <span class="text-xs text-indigo-400">Services</span>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                                <span class="text-sm text-gray-300">متابعين انستقرام</span>
                            </div>
                            <span class="text-sm font-bold text-white">72%</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full bg-green-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                <span class="text-sm text-gray-300">لايكات فيسبوك</span>
                            </div>
                            <span class="text-sm font-bold text-white">18%</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full bg-gray-700"></span>
                                <span class="text-sm text-gray-300">أخرى</span>
                            </div>
                            <span class="text-sm font-bold text-white">10%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Tab Content -->
    <div x-show="activeTab === 'settings'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="glass p-6 md:p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/10 rounded-bl-full"></div>
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        البيانات الأساسية
                    </h3>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="glass p-6 md:p-8 rounded-2xl border border-red-500/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-red-500/10 rounded-bl-full"></div>
                    <h3 class="text-xl font-bold text-red-500 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        منطقة الخطر
                    </h3>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass p-6 md:p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-purple-500/10 rounded-bl-full"></div>
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        الأمان وكلمة المرور
                    </h3>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
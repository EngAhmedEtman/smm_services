@extends('layouts.app')

@section('title', 'واتساب API | EtViral')

@section('header_title')
<div class="flex items-center gap-3">
    <div class="p-2 bg-indigo-500/10 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
        </svg>
    </div>
    <span>إعدادات واجهة البرمجيات (API)</span>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-purple-700 p-8 shadow-2xl shadow-indigo-500/20">
        <div class="absolute top-0 right-0 -m-8 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-right">
                <h1 class="text-3xl font-bold text-white mb-2">مرحباً بك في عالم المطورين</h1>
                <p class="text-indigo-100 text-lg opacity-90">استخدم الـ API Key الخاص بك لربط خدماتك بـ EtViral والبدء في إرسال الرسائل برمجياً.</p>
            </div>
            <div class="hidden md:block">
                <div class="w-32 h-32 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/30 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="glass rounded-3xl p-1 md:p-8 border border-white/5 shadow-2xl overflow-hidden">
        <div class="p-6 md:p-8 space-y-8">

            @if($token)
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-green-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-white">مفتاح الوصول الخاص بك (API Key)</h2>
                </div>

                <div class="relative group" x-data="{ show: false, token: '{{ $token }}' }">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative flex items-center justify-between bg-[#0f0f13] border border-white/10 rounded-2xl p-4 md:p-6 transition-all duration-300">
                        <div class="flex-1 overflow-hidden">
                            <code class="text-lg md:text-xl font-mono tracking-wider break-all text-gray-300 transition-all duration-300"
                                :class="show ? 'opacity-100' : 'blur-md select-none'">
                                {{ $token }}
                            </code>
                        </div>

                        <div class="flex items-center gap-2 mr-4">
                            <!-- Show/Hide Toggle -->
                            <button @click="show = !show" class="p-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl transition-all" title="إظهار/إخفاء">
                                <template x-if="!show">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="show">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.06m2.728-2.674A10.09 10.09 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3" />
                                    </svg>
                                </template>
                            </button>

                            <!-- Copy Button -->
                            <button @click="navigator.clipboard.writeText(token); showGlobalNotification('تم نسخ المفتاح بنجاح', 'success', 'عملية ناجحة')"
                                class="p-3 bg-indigo-600/20 text-indigo-400 hover:bg-indigo-600 hover:text-white rounded-xl transition-all active:scale-95 shadow-lg shadow-indigo-900/20"
                                title="نسخ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm text-yellow-200/80">
                        <strong>تنبيه أمني:</strong> لا تشارك هذا المفتاح مع أي شخص. أي شخص يمتلك هذا المفتاح يمكنه إرسال رسائل من حسابك.
                    </p>
                </div>
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-12 space-y-8 text-center">
                <div class="w-24 h-24 rounded-full bg-indigo-500/10 flex items-center justify-center border-2 border-indigo-500/20 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <div class="max-w-md space-y-3">
                    <h2 class="text-2xl font-bold text-white">لم يتم إنشاء مفتاح بعد</h2>
                    <p class="text-gray-400">ابدأ الآن بإنشاء مفتاح خاص بك لتتمكن من الوصول لخدمات الـ API الخاصة بـ EtViral.</p>
                </div>

                <form action="{{ route('create-token.store') }}" method="POST" class="w-full max-w-xs">
                    @csrf
                    <button type="submit" class="w-full group relative px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-600/25 active:scale-95 overflow-hidden">
                        <div class="absolute inset-0 w-1/2 h-full bg-white/10 -skew-x-12 -translate-x-full group-hover:translate-x-[250%] transition-transform duration-1000"></div>
                        <span class="relative flex items-center justify-center gap-2">
                            إنشاء مفتاح جديد
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
            @endif

            <!-- Documentation Snippet -->
            <div class="pt-8 border-t border-white/5 space-y-6">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="font-bold text-white uppercase tracking-wider text-sm">مثال لطلب الـ API</h3>
                </div>

                <div class="bg-[#0f0f13] rounded-2xl p-6 border border-white/5 font-mono text-sm space-y-2">
                    <div class="flex gap-4">
                        <span class="text-green-400">POST</span>
                        <span class="text-gray-400">{{ url('/api/v1/send') }}</span>
                    </div>
                    <div class="space-y-1 pt-2">
                        <div class="text-purple-400">Header:</div>
                        <div class="text-gray-300 pl-4">Authorization: Bearer <span class="text-indigo-400">{{ $token ? '********' : 'YOUR_API_KEY' }}</span></div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('api.docs') }}" class="group flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                        عرض توثيق الـ API كاملاً
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform group-hover:translate-x-[-4px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
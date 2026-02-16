@extends('layouts.app')

@section('title', 'واتساب API | EtViral')

@section('header_title')
<div class="flex items-center gap-3">
    <div class="p-2.5 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-xl backdrop-blur-sm border border-indigo-400/20">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
        </svg>
    </div>
    <span class="text-gray-200">إعدادات واجهة البرمجيات</span>
</div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">
    
    <!-- Hero Section with Modern Gradient -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 shadow-xl">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="text-right space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-white/90 text-sm font-medium">جاهز للاستخدام</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight">
                        مركز المطورين
                    </h1>
                    <p class="text-indigo-100/80 text-base md:text-lg leading-relaxed">
                        قم بدمج خدمات EtViral مع تطبيقاتك بسهولة من خلال API قوي ومرن
                    </p>
                    <div class="flex gap-3 pt-2">
                        <div class="flex items-center gap-2 text-white/70">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">آمن ومشفر</span>
                        </div>
                        <div class="flex items-center gap-2 text-white/70">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">سريع الاستجابة</span>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/10 rounded-3xl blur-2xl"></div>
                        <div class="relative w-40 h-40 bg-gradient-to-br from-white/20 to-white/5 backdrop-blur-xl rounded-3xl flex items-center justify-center border border-white/20 shadow-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-gradient-to-br from-gray-900/90 to-gray-800/90 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
        <div class="p-6 md:p-10 space-y-8">

            @if($token)
            <!-- API Key Section -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-10 bg-gradient-to-b from-green-400 to-emerald-600 rounded-full"></div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-white">مفتاح API الخاص بك</h2>
                            <p class="text-sm text-gray-400 mt-1">استخدم هذا المفتاح للمصادقة</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-green-500/10 border border-green-500/20 rounded-lg">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-green-400 text-sm font-medium">نشط</span>
                    </div>
                </div>

                <div x-data="{ show: false, token: '{{ $token }}', copied: false }" class="space-y-4">
                    <!-- API Key Display -->
                    <div class="group relative">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                        <div class="relative bg-[#0a0a0f] border border-white/10 rounded-2xl p-5 md:p-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-1 overflow-hidden">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Bearer Token</span>
                                    </div>
                                    <code class="block text-base md:text-lg font-mono text-gray-300 break-all transition-all duration-300 select-none"
                                        :class="show ? 'opacity-100 blur-none' : 'opacity-50 blur-sm'">
                                        {{ $token }}
                                    </code>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center gap-2">
                                    <!-- Toggle Visibility Button -->
                                    <button @click="show = !show" 
                                        class="p-3 bg-gray-800/50 hover:bg-gray-700/50 text-gray-400 hover:text-white rounded-xl transition-all duration-200 border border-white/5"
                                        :title="show ? 'إخفاء المفتاح' : 'إظهار المفتاح'">
                                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.06m2.728-2.674A10.09 10.09 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3" />
                                        </svg>
                                    </button>

                                    <!-- Copy Button -->
                                    <button @click="navigator.clipboard.writeText(token); copied = true; setTimeout(() => copied = false, 2000); showGlobalNotification('تم نسخ المفتاح بنجاح', 'success', 'عملية ناجحة')"
                                        class="relative p-3 bg-indigo-600/80 hover:bg-indigo-600 text-white rounded-xl transition-all duration-200 active:scale-95 shadow-lg shadow-indigo-600/30 border border-indigo-500/50"
                                        title="نسخ المفتاح">
                                        <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                        <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Warning -->
                    <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/20 rounded-xl backdrop-blur-sm">
                        <div class="shrink-0 w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-amber-200 mb-1">تحذير أمني مهم</h4>
                            <p class="text-sm text-amber-200/70 leading-relaxed">
                                احتفظ بهذا المفتاح في مكان آمن ولا تشاركه مع أي شخص. أي شخص يحصل عليه يمكنه الوصول الكامل لحسابك.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">الطلبات المتاحة</p>
                            <p class="text-2xl font-bold text-white">غير محدود</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">وقت الاستجابة</p>
                            <p class="text-2xl font-bold text-white">&lt; 100ms</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 border border-purple-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">الإصدار</p>
                            <p class="text-2xl font-bold text-white">v1.0</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            @else
            <!-- No Token State -->
            <div class="flex flex-col items-center justify-center py-16 space-y-6 text-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-indigo-500/20 blur-3xl rounded-full animate-pulse"></div>
                    <div class="relative w-28 h-28 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 flex items-center justify-center border-2 border-indigo-400/30 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>

                <div class="max-w-md space-y-3">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">لم يتم إنشاء مفتاح بعد</h2>
                    <p class="text-gray-400 leading-relaxed">
                        ابدأ رحلتك في عالم التطوير بإنشاء مفتاح API خاص بك للوصول لخدماتنا المتقدمة
                    </p>
                </div>

                <form action="{{ route('create-token.store') }}" method="POST" class="w-full max-w-sm pt-4">
                    @csrf
                    <button type="submit" class="group relative w-full px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl transition-all duration-300 shadow-2xl shadow-indigo-600/30 hover:shadow-indigo-600/50 active:scale-[0.98] overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-1000"></div>
                        <span class="relative flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            إنشاء مفتاح API جديد
                        </span>
                    </button>
                </form>

                <div class="flex items-center gap-6 pt-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>آمن</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>سريع</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>موثوق</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- API Documentation Preview -->
            <div class="pt-6 border-t border-white/5 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-800/50 rounded-lg flex items-center justify-center border border-white/5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">مثال سريع للاستخدام</h3>
                        <p class="text-sm text-gray-400">نموذج لطلب API بسيط</p>
                    </div>
                </div>

                <div class="bg-[#0a0a0f] rounded-xl p-5 md:p-6 border border-white/5 font-mono text-sm overflow-x-auto">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded text-xs font-bold border border-green-500/30">POST</span>
                            <span class="text-gray-400">{{ url('/api/v1/send') }}</span>
                        </div>
                        <div class="h-px bg-white/5"></div>
                        <div class="space-y-2">
                            <div class="text-purple-400 text-xs uppercase tracking-wider">Headers:</div>
                            <div class="pr-4 space-y-1">
                                <div class="text-gray-300">
                                    <span class="text-gray-500">Authorization:</span> 
                                    <span class="text-blue-400">Bearer</span> 
                                    <span class="text-indigo-400">{{ $token ? '••••••••' : 'YOUR_API_KEY' }}</span>
                                </div>
                                <div class="text-gray-300">
                                    <span class="text-gray-500">Content-Type:</span> 
                                    <span class="text-yellow-400">application/json</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>تحقق من التوثيق الكامل للمزيد من التفاصيل</span>
                    </div>
                    <a href="{{ route('doc.api.inDashboard') }}" 
                        class="group flex items-center gap-2 px-5 py-2.5 bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 hover:text-indigo-300 font-medium rounded-lg transition-all duration-200 border border-indigo-500/20">
                        <span>عرض التوثيق الكامل</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform group-hover:translate-x-[-4px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Resources -->
    <div class="grid md:grid-cols-3 gap-4">
        <a href="#" class="group p-6 bg-gradient-to-br from-gray-900/50 to-gray-800/50 backdrop-blur-sm border border-white/5 rounded-xl hover:border-indigo-500/30 transition-all duration-300">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h3 class="text-white font-bold mb-2">التوثيق</h3>
            <p class="text-gray-400 text-sm">دليل شامل لاستخدام الـ API</p>
        </a>

        <a href="#" class="group p-6 bg-gradient-to-br from-gray-900/50 to-gray-800/50 backdrop-blur-sm border border-white/5 rounded-xl hover:border-purple-500/30 transition-all duration-300">
            <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <h3 class="text-white font-bold mb-2">أمثلة الكود</h3>
            <p class="text-gray-400 text-sm">نماذج جاهزة بلغات مختلفة</p>
        </a>

        <a href="#" class="group p-6 bg-gradient-to-br from-gray-900/50 to-gray-800/50 backdrop-blur-sm border border-white/5 rounded-xl hover:border-green-500/30 transition-all duration-300">
            <div class="w-12 h-12 bg-green-500/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-white font-bold mb-2">الدعم الفني</h3>
            <p class="text-gray-400 text-sm">فريقنا جاهز لمساعدتك</p>
        </a>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .7;
        }
    }
</style>
@endsection
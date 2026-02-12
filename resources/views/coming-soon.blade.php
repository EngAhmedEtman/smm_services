@extends('layouts.app')

@section('title', 'قريباً | EtViral')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center p-6 bg-[#16161a] rounded-3xl border border-gray-800 relative overflow-hidden">
    <!-- Background Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10">
        <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-indigo-500/20 transform rotate-3 hover:rotate-6 transition-transform duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </div>

        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">قريباً جداً</h1>
        <p class="text-gray-400 text-lg max-w-md mx-auto mb-8">
            نحن نعمل بجد لإطلاق هذه الميزة الجديدة. تابعنا لمعرفة آخر التحديثات!
        </p>

        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-xl font-medium transition-colors border border-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            العودة للرئيسية
        </a>
    </div>
</div>
@endsection
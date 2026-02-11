@extends('layouts.app')

@section('title', 'التذاكر | Etman SMM')
@section('header_title', 'التذاكر')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                التذاكر
            </h1>
            <p class="text-gray-400 mt-1">إدارة تذاكر الدعم الفني</p>
        </div>
    </div>

    {{-- Coming Soon --}}
    <div class="glass rounded-2xl p-12 flex flex-col items-center justify-center text-center">
        <div class="w-24 h-24 rounded-full bg-purple-500/10 flex items-center justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">قريباً...</h3>
        <p class="text-gray-400 text-sm max-w-md">نظام التذاكر قيد التطوير حالياً. سيمكنك من استقبال وإدارة طلبات الدعم الفني من المستخدمين.</p>
        <div class="mt-6 flex items-center gap-2 text-xs text-purple-400 bg-purple-500/10 px-4 py-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            تحت التطوير
        </div>
    </div>
</div>
@endsection
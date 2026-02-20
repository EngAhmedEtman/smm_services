@extends('layouts.app')

@section('title', 'المستخدمون الآن | Etman SMM')
@section('header_title', 'المستخدمون الآن')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                المستخدمون الآن
            </h1>
            <p class="text-gray-400 mt-1">المستخدمون النشطون خلال آخر 5 دقائق</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-green-500/20 text-green-400 border border-green-500/30 text-sm font-bold px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                {{ $onlineUsers->count() }} متصل الآن
            </div>
            {{-- Auto-refresh every 60s --}}
            <button onclick="window.location.reload()" class="bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm px-3 py-1.5 rounded-full transition-colors flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                تحديث
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass p-4 rounded-xl border border-green-500/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728M8.464 15.536a5 5 0 010-7.072m7.072 0a5 5 0 010 7.072M13 12a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">متصل الآن</p>
                    <p class="text-2xl font-bold text-green-400">{{ $onlineUsers->count() }}</p>
                    <p class="text-[10px] text-gray-600">آخر 5 دقائق</p>
                </div>
            </div>
        </div>
        <div class="glass p-4 rounded-xl border border-yellow-500/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">نشط مؤخراً</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $recentUsers->count() }}</p>
                    <p class="text-[10px] text-gray-600">آخر ساعة</p>
                </div>
            </div>
        </div>
        <div class="glass p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gray-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">إجمالي المستخدمين</p>
                    <p class="text-2xl font-bold text-white">{{ \App\Models\User::count() }}</p>
                    <p class="text-[10px] text-gray-600">كل الحسابات</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Online Users --}}
    @if($onlineUsers->isNotEmpty())
    <div class="glass rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700/50 flex items-center gap-3">
            <span class="w-2.5 h-2.5 rounded-full bg-green-400 animate-pulse"></span>
            <h2 class="text-white font-semibold">متصلون الآن</h2>
            <span class="text-xs text-gray-500">(آخر 5 دقائق)</span>
        </div>
        <div class="divide-y divide-gray-700/30">
            @foreach($onlineUsers as $user)
            <div class="flex items-center justify-between px-6 py-4 hover:bg-white/5 transition-colors">
                <div class="flex items-center gap-4">
                    {{-- Avatar --}}
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500/30 to-emerald-600/30 border border-green-500/30 flex items-center justify-center text-green-400 font-bold text-sm">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <span class="absolute bottom-0 left-0 w-3 h-3 rounded-full bg-green-400 border-2 border-[#16161a] shadow-[0_0_6px_rgba(34,197,94,0.6)]"></span>
                    </div>
                    {{-- Info --}}
                    <div>
                        <p class="text-sm font-medium text-white">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    {{-- Role Badge --}}
                    <span class="hidden sm:inline-flex text-xs font-medium px-2.5 py-0.5 rounded-full
                        {{ $user->role === 'super_admin' ? 'bg-red-500/10 text-red-400' :
                          ($user->role === 'admin' ? 'bg-orange-500/10 text-orange-400' :
                           'bg-gray-700 text-gray-400') }}">
                        {{ $user->role === 'super_admin' ? 'سوبر أدمن' : ($user->role === 'admin' ? 'أدمن' : 'مستخدم') }}
                    </span>
                    {{-- Balance --}}
                    <span class="hidden md:block text-xs font-medium text-emerald-400">
                        {{ number_format($user->balance, 2) }} جنيه
                    </span>
                    {{-- Last seen --}}
                    <div class="text-left ltr">
                        <p class="text-xs text-green-400 font-medium">متصل الآن</p>
                        <p class="text-[10px] text-gray-600">منذ {{ $user->last_seen_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="glass rounded-2xl p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <p class="text-gray-500">لا يوجد مستخدمون متصلون الآن</p>
    </div>
    @endif

    {{-- Recently Active Users --}}
    @if($recentUsers->isNotEmpty())
    <div class="glass rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700/50 flex items-center gap-3">
            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
            <h2 class="text-white font-semibold">نشطون مؤخراً</h2>
            <span class="text-xs text-gray-500">(آخر ساعة)</span>
        </div>
        <div class="divide-y divide-gray-700/30">
            @foreach($recentUsers as $user)
            <div class="flex items-center justify-between px-6 py-4 hover:bg-white/5 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gray-700 border border-gray-600 flex items-center justify-center text-gray-300 font-bold text-sm">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <span class="absolute bottom-0 left-0 w-3 h-3 rounded-full bg-yellow-400 border-2 border-[#16161a]"></span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <span class="hidden sm:inline-flex text-xs font-medium px-2.5 py-0.5 rounded-full
                        {{ $user->role === 'super_admin' ? 'bg-red-500/10 text-red-400' :
                          ($user->role === 'admin' ? 'bg-orange-500/10 text-orange-400' :
                           'bg-gray-700 text-gray-400') }}">
                        {{ $user->role === 'super_admin' ? 'سوبر أدمن' : ($user->role === 'admin' ? 'أدمن' : 'مستخدم') }}
                    </span>
                    <span class="hidden md:block text-xs font-medium text-emerald-400">
                        {{ number_format($user->balance, 2) }} جنيه
                    </span>
                    <div class="text-left ltr">
                        <p class="text-xs text-yellow-400 font-medium">غير متصل</p>
                        <p class="text-[10px] text-gray-600">{{ $user->last_seen_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
    // Auto-refresh every 60 seconds
    setTimeout(() => window.location.reload(), 60000);
</script>
@endpush
@endsection
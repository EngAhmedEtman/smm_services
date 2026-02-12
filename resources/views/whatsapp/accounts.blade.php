@extends('layouts.app')

@section('title', 'حساباتي | Etman SMM')

@section('content')
<div class="space-y-8 direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 right-0 w-[500px] h-[500px] bg-green-600/10 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#1e1e24]/60 backdrop-blur-md p-6 rounded-2xl border border-green-500/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/5 to-transparent pointer-events-none"></div>

        <div>
            <h2 class="text-2xl font-bold text-white mb-1 flex items-center gap-2">
                <span class="w-2 h-8 bg-green-500 rounded-full inline-block"></span>
                حسابات واتساب
            </h2>
            <p class="text-gray-400 text-sm">إدارة الحسابات المرتبطة وحالتها</p>
        </div>

        <a href="{{ route('whatsapp.connect') }}" class="w-full md:w-auto bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-green-900/30 flex items-center justify-center gap-2 transform hover:-translate-y-1 active:scale-95 group">
            <div class="bg-white/20 p-1 rounded-full group-hover:rotate-90 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <span>ربط حساب جديد</span>
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 animate-pulse">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 animate-pulse">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($accounts as $account)
        <!-- Account Card -->
        <div class="bg-[#1e1e24]/80 backdrop-blur-md p-6 rounded-2xl relative overflow-hidden group border border-gray-800/50 hover:border-green-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-green-900/10 transform hover:-translate-y-1">

            <!-- Card Glow -->
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-green-500/10 rounded-full group-hover:bg-green-500/20 blur-2xl transition-all duration-700"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#25D366] to-[#128C7E] flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                            </div>
                            <!-- Status Indicator Dot -->
                            <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-[#1e1e24] {{ $account->status == 'connected' ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg group-hover:text-green-400 transition-colors" dir="ltr">
                                {{ $account->phone_number ? '+' . $account->phone_number : 'WhatsApp' }}
                            </h3>
                            <p class="text-xs text-gray-500 font-mono mt-0.5">{{ $account->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $account->status == 'connected' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20' }}">
                        {{ ucfirst($account->status) }}
                    </span>
                </div>

                <div class="bg-[#16161a]/50 rounded-xl p-3 border border-gray-700/30 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Instance ID</span>
                        <span class="font-mono text-white font-bold text-sm tracking-wide">{{ $account->instance_id }}</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    {{-- Logout (Reboot) - Only if Connected --}}
                    @if($account->status == 'connected')
                    <form action="{{ route('whatsapp.reboot', ['instance_id' => $account->instance_id]) }}" method="GET" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-500 border border-yellow-500/20 py-2.5 rounded-lg text-sm font-bold transition-all hover:shadow-lg hover:shadow-yellow-900/20 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            خروج
                        </button>
                    </form>
                    @endif

                    {{-- Reconnect - Only if Disconnected --}}
                    @if($account->status == 'disconnected')
                    <a href="{{ route('whatsapp.reconnect', ['instance_id' => $account->instance_id]) }}" class="flex-1 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/20 py-2.5 rounded-lg text-sm font-bold transition-all hover:shadow-lg hover:shadow-blue-900/20 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        إعادة اتصال
                    </a>
                    @endif

                    {{-- Reset Instance (Delete) - Always Visible --}}
                    <form action="{{ route('whatsapp.reset', ['instance_id' => $account->instance_id]) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد؟ سيتم حذف بيانات هذا الحساب وإلغاء ربطه تماماً.')">
                        @csrf
                        <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-500 border border-red-500/20 py-2.5 rounded-lg text-sm font-bold transition-all hover:shadow-lg hover:shadow-red-900/20 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full text-center py-20 bg-[#1e1e24]/40 backdrop-blur rounded-3xl border border-dashed border-gray-700 hover:border-green-500/50 transition-colors group">
            <div class="w-20 h-20 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">لا توجد حسابات مرتبطة</h3>
            <p class="text-gray-400 mb-8 max-w-sm mx-auto">قم بربط حساب واتساب جديد للبدء في إرسال الرسائل وإدارة الحملات بكل سهولة.</p>
            <a href="{{ route('whatsapp.connect') }}" class="inline-flex bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-green-900/30 hover:shadow-green-900/50 transform hover:-translate-y-1">
                ربط حساب جديد الآن
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
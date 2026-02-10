@extends('layouts.app')

@section('title', 'حساباتي | Etman SMM')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-white">حسابات واتساب المرتبطة</h2>
        <a href="{{ route('whatsapp.connect') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-bold transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            ربط حساب جديد
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm mb-6 break-words">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($accounts as $account)
        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:bg-green-500/20 transition-all duration-500"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/10 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white">WhatsApp</h3>
                            <p class="text-xs text-gray-400">{{ $account->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-md text-xs font-bold {{ $account->status == 'connected' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                        {{ ucfirst($account->status) }}
                    </span>
                </div>

                <div class="space-y-2 text-sm text-gray-300">
                    <div class="flex justify-between">
                        <span>Instance ID:</span>
                        <span class="font-mono text-indigo-300">{{ $account->instance_id }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/10 flex gap-2">
                    {{-- Logout (Reboot) - Only if Connected --}}
                    @if($account->status == 'connected')
                    <form action="{{ route('whatsapp.reboot', ['instance_id' => $account->instance_id]) }}" method="GET" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-400 py-2 rounded-lg text-sm transition-colors block text-center">
                            تسجيل خروج
                        </button>
                    </form>
                    @endif

                    {{-- Reconnect - Only if Disconnected --}}
                    @if($account->status == 'disconnected')
                    <a href="{{ route('whatsapp.reconnect', ['instance_id' => $account->instance_id]) }}" class="flex-1 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 py-2 rounded-lg text-sm transition-colors block text-center flex justify-center items-center">
                        إعادة اتصال
                    </a>
                    @endif

                    {{-- Reset Instance (Delete) - Always Visible --}}
                    <form action="{{ route('whatsapp.reset', ['instance_id' => $account->instance_id]) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد؟ سيتم حذف بيانات هذا الحساب وإلغاء ربطه تماماً.')">
                        @csrf
                        <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 py-2 rounded-lg text-sm transition-colors block text-center">
                            حذف نهائي
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 glass rounded-2xl">
            <div class="bg-white/5 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">لا توجد حسابات مرتبطة</h3>
            <p class="text-gray-400 mb-6">قم بربط حساب واتساب جديد للبدء في إرسال الرسائل.</p>
            <a href="{{ route('whatsapp.connect') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition-colors">
                ربط حساب جديد
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
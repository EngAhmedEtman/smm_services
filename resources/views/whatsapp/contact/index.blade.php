@extends('layouts.app')

@section('title', 'مجموعات الأرقام | Etman SMM')

@section('content')
<div class="space-y-8 direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 right-0 w-[400px] h-[400px] bg-green-600/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#1e1e24]/60 backdrop-blur-md p-6 rounded-2xl border border-green-500/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/5 to-transparent pointer-events-none"></div>
        <div>
            <h2 class="text-2xl font-bold text-white mb-1 flex items-center gap-2">
                <span class="w-2 h-8 bg-green-500 rounded-full inline-block"></span>
                مجموعات الأرقام
            </h2>
            <p class="text-gray-400 text-sm">إدارة قوائم جهات الاتصال وحملاتك المستهدفة</p>
        </div>
        <a href="{{ route('whatsapp.contact.create') }}" class="w-full md:w-auto bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-green-900/30 flex items-center justify-center gap-2 transform hover:-translate-y-1 active:scale-95 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <span>إضافة مجموعة جديدة</span>
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in-up shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($contacts as $contact)
        <div class="bg-[#1e1e24]/80 backdrop-blur-md border border-gray-800/60 rounded-2xl p-5 relative hover:bg-[#222228] transition-all duration-300 group hover:border-green-500/30 shadow-md hover:shadow-xl flex flex-col justify-between h-full">

            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500/20 to-emerald-600/10 border border-green-500/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-900/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight group-hover:text-green-400 transition-colors line-clamp-1" title="{{ $contact->contact_name }}">
                            {{ $contact->contact_name }}
                        </h3>
                        <span class="text-xs text-gray-500 font-mono">{{ $contact->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="bg-gray-800/50 px-2 py-1 rounded text-[10px] text-gray-400 border border-gray-700 font-mono">
                    #{{ $contact->id }}
                </div>
            </div>

            <div class="bg-gray-900/40 rounded-xl p-3 mb-4 border border-gray-800/50">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">عدد الأرقام:</span>
                    <span class="font-bold text-white bg-green-500/10 px-2 py-0.5 rounded text-green-400 border border-green-500/10">{{ $contact->numbers_count }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2 pt-3 border-t border-gray-800/50 mt-auto">
                <a href="{{ route('whatsapp.contact.edit', $contact->id) }}" class="flex-1 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 hover:text-indigo-300 py-2 rounded-lg transition-colors border border-indigo-500/20 text-center text-sm font-bold flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    تعديل
                </a>
                <form action="{{ route('whatsapp.contact.delete', $contact->id) }}" method="POST" class="flex-1" onsubmit="return confirm('تنبيه: سيتم حذف جميع الأرقام المرتبطة بهذه المجموعة. هل أنت متأكد؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 py-2 rounded-lg transition-colors border border-red-500/20 text-center text-sm font-bold flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        حذف
                    </button>
                </form>
            </div>

        </div>
        @empty
        <div class="col-span-full text-center py-20 bg-[#1e1e24]/40 backdrop-blur rounded-3xl border border-dashed border-gray-700 hover:border-green-500/50 transition-colors group">
            <div class="w-20 h-20 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">لا توجد مجموعات محفوظة</h3>
            <p class="text-gray-400 mb-8 max-w-sm mx-auto">ابدأ بإنشاء أول مجموعة أرقام لاستخدامها في حملاتك.</p>
            <a href="{{ route('whatsapp.contact.create') }}" class="inline-flex bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-green-900/30 hover:shadow-green-900/50 transform hover:-translate-y-1">
                إضافة مجموعة جديدة
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
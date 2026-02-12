@extends('layouts.app')

@section('title', 'اختبار API واتساب | Etman SMM')

@section('header_title', 'اختبار الإرسال (API Test)')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 direction-rtl">

    <div class="flex items-center gap-4 bg-[#1e1e24]/60 backdrop-blur-md p-6 rounded-2xl border border-green-500/10 mb-8">
        <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-white">اختبار الإرسال (API Test)</h2>
            <p class="text-gray-400 text-sm">إرسال رسالة تجريبية للتأكد من حالة الربط.</p>
        </div>
    </div>

    @if(session('api_response'))
    <div class="bg-[#1e1e24]/80 backdrop-blur-md border border-indigo-500/30 p-6 rounded-2xl relative overflow-hidden animate-fade-in-up">
        <h3 class="text-white font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            نتيجة الطلب (API Response)
        </h3>
        <pre class="bg-[#16161a] rounded-xl p-4 text-xs font-mono text-green-400 overflow-x-auto dir-ltr text-left border border-white/5 shadow-inner">{{ json_encode(session('api_response'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
    @endif

    <div class="bg-[#1e1e24]/60 backdrop-blur-md p-8 rounded-3xl border border-gray-800/50 shadow-xl relative overflow-hidden">

        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/5 rounded-bl-full pointer-events-none"></div>

        <form action="{{ route('whatsapp.send') }}" method="POST" class="space-y-6 relative z-10">
            @csrf

            <!-- Instance Select -->
            <div class="group">
                <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">اختر الرقم المرسل (Instance)</label>
                <div class="relative">
                    <select name="instance_id" class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-4 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all appearance-none cursor-pointer hover:bg-[#16161a]" required>
                        @foreach($instances as $instance)
                        <option value="{{ $instance->instance_id }}">
                            {{ $instance->instance_id }} ({{ $instance->status }})
                        </option>
                        @endforeach
                        @if($instances->isEmpty())
                        <option value="" disabled selected>لا توجد حسابات متصلة</option>
                        @endif
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @if($instances->isEmpty())
                <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    يجب عليك ربط حساب واتساب أولاً.
                </p>
                @endif
            </div>

            <!-- Recipient Number -->
            <div class="group">
                <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">رقم المستلم (مع كود الدولة)</label>
                <div class="relative">
                    <input type="text" name="number" placeholder="مثال: 201012345678" class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-4 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all dir-ltr text-left placeholder-gray-600 hover:bg-[#16161a]" required>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Message -->
            <div class="group">
                <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">الرسالة</label>
                <textarea name="message" rows="4" placeholder="اكتب رسالة تجريبية..." class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-4 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all resize-none placeholder-gray-600 hover:bg-[#16161a]" required></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-green-900/30 flex items-center justify-center gap-2 transform hover:-translate-y-1 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
                <span>إرسال رسالة تجريبية</span>
            </button>
        </form>
    </div>
</div>
@endsection
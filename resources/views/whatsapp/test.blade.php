@extends('layouts.app')

@section('title', 'اختبار API واتساب | Etman SMM')

@section('header_title', 'اختبار الإرسال (API Test)')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    @if(session('api_response'))
    <div class="glass border border-indigo-500/30 p-6 rounded-2xl relative overflow-hidden">
        <h3 class="text-white font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            نتيجة الطلب (API Response)
        </h3>
        <pre class="bg-gray-900 rounded-lg p-4 text-xs font-mono text-green-400 overflow-x-auto dir-ltr text-left">{{ json_encode(session('api_response'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
    @endif

    <div class="glass p-8 rounded-2xl border border-gray-800">
        <form action="{{ route('whatsapp.send') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Instance Select -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">اختر الرقم المرسل (Instance)</label>
                <select name="instance_id" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    @foreach($instances as $instance)
                    <option value="{{ $instance->instance_id }}">
                        {{ $instance->instance_id }} ({{ $instance->status }})
                    </option>
                    @endforeach
                    @if($instances->isEmpty())
                    <option value="" disabled selected>لا توجد حسابات متصلة</option>
                    @endif
                </select>
                @if($instances->isEmpty())
                <p class="text-xs text-red-500 mt-2">يجب عليك ربط حساب واتساب أولاً من صفحة "ربط جهاز جديد".</p>
                @endif
            </div>

            <!-- Recipient Number -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">رقم المستلم (مع كود الدولة)</label>
                <input type="text" name="number" placeholder="مثال: 201012345678" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all dir-ltr text-left" required>
            </div>

            <!-- Message -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">الرسالة</label>
                <textarea name="message" rows="4" placeholder="اكتب رسالة تجريبية..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all" required></textarea>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
                إرسال رسالة تجريبية
            </button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'إنشاء قالب رسائل')

@section('header_title', 'إنشاء قالب رسائل جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
        <form action="{{ route('whatsapp.messages.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">اسم القالب</label>
                    <input type="text" name="name" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="مثال: رسائل الترحيب للعملاء الجدد" required>
                </div>

                <!-- Messages (Dynamic List) -->
                <div x-data="{ messages: [''] }">
                    <label class="block text-sm font-medium text-gray-400 mb-2">نصوص الرسائل (التبديل العشوائي)</label>
                    <div class="space-y-4">
                        <template x-for="(msg, index) in messages" :key="index">
                            <div class="relative">
                                <textarea :name="'content[' + index + ']'" rows="3" x-model="messages[index]" placeholder="نص الرسالة..." class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all pr-10" required></textarea>
                                <button type="button" @click="messages.splice(index, 1)" x-show="messages.length > 1" class="absolute top-2 left-2 text-red-500 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <span class="absolute top-2 right-2 text-xs text-gray-600 font-mono" x-text="'#' + (index + 1)"></span>
                            </div>
                        </template>
                    </div>
                    <div class="mt-2 text-right">
                        <button type="button" @click="if(messages.length < 5) messages.push('')" x-show="messages.length < 5" class="text-indigo-400 hover:text-indigo-300 text-sm font-bold flex items-center gap-1 inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            إضافة رسالة بديلة
                        </button>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-800 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg shadow-indigo-600/20">
                        حفظ القالب
                    </button>
                    <a href="{{ route('whatsapp.messages.index') }}" class="mr-3 text-gray-400 hover:text-white px-4 py-3 rounded-lg font-medium transition-all">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
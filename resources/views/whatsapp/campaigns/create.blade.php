@extends('layouts.app')

@section('title', 'إنشاء حملة واتساب جديدة | Etman SMM')

@section('header_title', 'إنشاء حملة واتساب جديدة')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="glass relative overflow-hidden rounded-2xl border border-gray-800 p-8">
        <form action="{{ route('whatsapp.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Campaign Name -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">اسم الحملة</label>
                <input type="text" name="campaign_name" placeholder="مثال: خصومات عيد رمضان" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Select Instance -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">الرقم المرسل (Instance)</label>
                    <select name="instance_id" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        @foreach($instances as $instance)
                        <option value="{{ $instance->instance_id }}">{{ $instance->instance_id }} ({{ $instance->status }})</option>
                        @endforeach
                        @if($instances->isEmpty())
                        <option value="" disabled selected>لا توجد أرقام متصلة</option>
                        @endif
                    </select>
                </div>

                <!-- Select Group -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">المجموعة المستهدفة</label>
                    <select name="whatsapp_contact_id" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->contact_name }} ({{ $group->numbers_count }} رقم)</option>
                        @endforeach
                        @if($groups->isEmpty())
                        <option value="" disabled selected>لا توجد مجموعات</option>
                        @endif
                    </select>
                </div>
            </div>

            <!-- Message Source Selection -->
            <div x-data="{ messageMode: 'template', messages: [''] }" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">نوع الرسالة</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="message_mode" value="template" x-model="messageMode" class="bg-gray-900 border-gray-700 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-300">اختيار قالب محفوظ</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="message_mode" value="custom" x-model="messageMode" class="bg-gray-900 border-gray-700 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-300">كتابة رسالة مخصصة</span>
                        </label>
                    </div>
                </div>

                <!-- Template Selection (Shown if messageMode == 'template') -->
                <div x-show="messageMode === 'template'" class="space-y-2">
                    <label class="block text-sm font-medium text-gray-400">اختر القالب</label>
                    <select name="whatsapp_message_id" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">-- اختر قالب الرسائل --</option>
                        @foreach($templates as $template)
                        <option value="{{ $template->id }}">
                            {{ $template->name }} ({{ count($template->content ?? []) }} رسائل)
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Custom Messages (Shown if messageMode == 'custom') -->
                <div x-show="messageMode === 'custom'">
                    <label class="block text-sm font-medium text-gray-400 mb-2">رسائل الحملة (التبديل العشوائي)</label>
                    <div class="space-y-4">
                        <template x-for="(msg, index) in messages" :key="index">
                            <div class="relative">
                                <textarea :name="'message[' + index + ']'" rows="3" x-model="messages[index]" placeholder="نص الرسالة..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all pr-10"></textarea>
                                <button type="button" @click="messages.splice(index, 1)" x-show="messages.length > 1" class="absolute top-2 left-2 text-red-500 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <span class="absolute top-2 right-2 text-xs text-gray-600 font-mono" x-text="'#' + (index + 1)"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mt-2 text-right" x-show="messageMode === 'custom'">
                    <button type="button" @click="if(messages.length < 5) messages.push('')" x-show="messages.length < 5" class="text-indigo-400 hover:text-indigo-300 text-sm font-bold flex items-center gap-1 inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        إضافة رسالة بديلة
                    </button>
                    <p class="text-xs text-gray-500 mt-1">يمكنك إضافة حتى 5 رسائل سيتم التبديل بينهم عشوائياً لتجنب الحظر.</p>
                </div>
            </div>

            <!-- Delays -->
            <div class="grid md:grid-cols-2 gap-6 bg-gray-800/30 p-4 rounded-xl border border-gray-700/50">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">أقل مدة تأخير (ثواني)</label>
                    <input type="number" name="min_delay" value="5" min="1" max="3600" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all text-center">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">أقصى مدة تأخير (ثواني)</label>
                    <input type="number" name="max_delay" value="15" min="1" max="3600" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all text-center">
                </div>
                <div class="col-span-2 text-center text-xs text-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    ينصح بزيادة الفاصل الزمني لتجنب حظر الرقم من واتساب.
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    إنشاء وبدء الحملة
                </button>
                <a href="{{ route('whatsapp.campaigns.index') }}" class="px-8 py-4 rounded-xl border border-gray-600 text-gray-300 hover:bg-white/5 transition-all text-center font-bold">
                    إلغاء
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
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
                    <!-- Messages (Dynamic List for Custom Mode) -->
                    <div x-data="{ messages: [''] }" class="space-y-4">
                        <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors">نصوص الرسائل (التبديل العشوائي)</label>

                        <div class="space-y-4">
                            <template x-for="(msg, index) in messages" :key="index">
                                <div class="relative group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">محتوى الرسالة</label>

                                    <!-- Shortcode Helpers -->
                                    <div class="flex gap-2 mb-2 flex-wrap">
                                        <button type="button" @click="insertAtCursor($el.closest('.relative').querySelector('textarea'), '@{{random}}')"
                                            class="bg-purple-500/10 text-purple-400 border border-purple-500/20 px-2 py-1 rounded text-xs hover:bg-purple-500/20 transition-colors">
                                            @{{random}} نص عشوائي
                                        </button>
                                        <button type="button" @click="insertAtCursor($el.closest('.relative').querySelector('textarea'), '@{{welcome}}')"
                                            class="bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-1 rounded text-xs hover:bg-green-500/20 transition-colors">
                                            @{{welcome}} ترحيب
                                        </button>
                                        <button type="button" @click="insertAtCursor($el.closest('.relative').querySelector('textarea'), '@{{date}}')"
                                            class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-1 rounded text-xs hover:bg-blue-500/20 transition-colors">
                                            @{{date}} التاريخ
                                        </button>
                                    </div>

                                    <textarea :name="'message[' + index + ']'" rows="3" x-model="messages[index]" placeholder="نص الرسالة..." class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all resize-y min-h-[100px] hover:bg-[#16161a]"></textarea>

                                    <!-- Delete Button -->
                                    <button type="button" @click="messages.splice(index, 1)" x-show="messages.length > 1" class="absolute top-3 left-3 text-red-500 hover:text-red-400 bg-red-500/10 p-1.5 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <!-- Counter Badge -->
                                    <span class="absolute top-3 right-3 text-[10px] text-gray-500 font-bold bg-[#1e1e24] px-2 py-1 rounded border border-gray-700" x-text="'#' + (index + 1)"></span>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="button" @click="if(messages.length < 10) messages.push('')" x-show="messages.length < 10" class="bg-green-500/10 hover:bg-green-500/20 text-green-400 hover:text-green-300 text-sm font-bold px-4 py-2 rounded-lg transition-all inline-flex items-center gap-2 border border-green-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                إضافة رسالة بديلة
                            </button>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed">سيتم اختيار رسالة واحدة عشوائياً لكل رقم.</p>
                        </div>

                        <!-- Media Attachment -->
                        <div class="group bg-[#16161a]/40 p-4 rounded-xl border border-dashed border-gray-700/50 mt-4">
                            <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">إرفاق ملف أو صورة (اختياري)</label>
                            <input type="file" name="media" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-500/10 file:text-green-400 hover:file:bg-green-500/20 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-2">الملفات المسموحة: الصور (jpg, png)، المستندات (pdf, docx, txt) بحد أقصى 10 ميجابايت.</p>
                        </div>
                    </div>
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

@push('scripts')
<script>
    function insertAtCursor(myField, myValue) {
        //IE support
        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = myValue;
        }
        //MOZILLA and others
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            myField.value = myField.value.substring(0, startPos) +
                myValue +
                myField.value.substring(endPos, myField.value.length);
            myField.selectionStart = startPos + myValue.length;
            myField.selectionEnd = startPos + myValue.length;
        } else {
            myField.value += myValue;
        }
        // Trigger input event for Alpine/Vue if needed
        myField.dispatchEvent(new Event('input'));
    }
</script>
@endpush
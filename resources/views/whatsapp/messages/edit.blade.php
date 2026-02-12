@extends('layouts.app')

@section('title', 'تعديل قالب رسائل | Etman SMM')

@section('content')
<div class="max-w-3xl mx-auto direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 left-0 w-[400px] h-[400px] bg-indigo-600/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800/80 rounded-3xl p-8 relative overflow-hidden shadow-2xl">

        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-bl-full pointer-events-none"></div>

        <div class="flex items-center gap-4 mb-8 relative z-10">
            <a href="{{ route('whatsapp.messages.index') }}" class="w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center hover:bg-gray-800 transition-colors text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">تعديل قالب رسائل</h2>
                <p class="text-gray-400 text-sm">تحديث نصوص الرسائل في هذا القالب</p>
            </div>
        </div>

        <form action="{{ route('whatsapp.messages.update', $message->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="group">
                <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-indigo-400">اسم القالب</label>
                <input type="text" name="name" value="{{ $message->name }}" class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-gray-600 hover:bg-[#16161a]" required>
            </div>

            <!-- Messages (Dynamic List) -->
            <div x-data="{ messages: {{ json_encode($message->content) }} }" class="space-y-4">
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

                            <textarea :name="'content[' + index + ']'" rows="3" x-model="messages[index]" class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all resize-y min-h-[100px] hover:bg-[#16161a]"></textarea>

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
                    <button type="button" @click="if(messages.length < 10) messages.push('')" x-show="messages.length < 10" class="bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 hover:text-indigo-300 text-sm font-bold px-4 py-2 rounded-lg transition-all inline-flex items-center gap-2 border border-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        إضافة رسالة بديلة
                    </button>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">يمكنك إضافة حتى 10 رسائل مختلفة للتبديل بينها.</p>
                </div>
            </div>

            <!-- Media Attachment -->
            <div class="group bg-[#16161a]/40 p-4 rounded-xl border border-dashed border-gray-700/50">
                <label class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-indigo-400">إرفاق ملف أو صورة (اختياري)</label>
                @if($message->media_path)
                <div class="flex items-center gap-2 mb-3 bg-indigo-500/10 p-2 rounded-lg border border-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-indigo-300">يوجد ملف مرفق حالياً. قم برفع ملف جديد لاستبداله.</span>
                </div>
                @endif
                <input type="file" name="media" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">الملفات المسموحة: الصور (jpg, png)، المستندات (pdf, docx, txt) بحد أقصى 10 ميجابايت.</p>
            </div>

            <div class="pt-4 flex flex-col-reverse md:flex-row gap-4">
                <a href="{{ route('whatsapp.messages.index') }}" class="px-6 py-3.5 rounded-xl border border-gray-600 text-gray-300 hover:bg-white/5 transition-all text-center font-bold">
                    إلغاء
                </a>
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2 transform hover:-translate-y-1 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    حفظ التعديلات
                </button>
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
@extends('layouts.app')

@section('title', 'إنشاء حملة واتساب جديدة | Etman SMM')

@section('header_title', 'إنشاء حملة واتساب جديدة')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 direction-rtl">

    <!-- Header & Back Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <span class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                إنشاء حملة جديدة
            </h2>
            <p class="text-gray-400 text-sm mt-1 mr-12">قم بإعداد حملتك الإعلانية بخطوات بسيطة وذكية.</p>
        </div>
        <a href="{{ route('whatsapp.campaigns.index') }}" class="group flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-800/50 hover:bg-gray-800 text-gray-400 hover:text-white transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:-translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            <span>رجوع للقائمة</span>
        </a>
    </div>

    <form action="{{ route('whatsapp.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ messageMode: 'template', previewMessage: '' }">
        @csrf

        <div class="space-y-8">

            <!-- Main Form Layout -->
            <div class="space-y-8">

                <!-- Main Form Section -->
                <div class="space-y-8">

                    <!-- Step 1: Basic Info -->
                    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl p-6 relative overflow-hidden group hover:border-indigo-500/30 transition-all">
                        <div class="absolute top-0 right-0 w-1 h-full bg-indigo-600 origin-top transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500"></div>

                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <span class="bg-indigo-500/10 text-indigo-400 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-mono border border-indigo-500/20">01</span>
                            تفاصيل الحملة
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">اسم الحملة</label>
                                <div class="relative">
                                    <span class="absolute right-4 top-3.5 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </span>
                                    <input type="text" name="campaign_name" placeholder="مثال: خصومات الجمعة البيضاء"
                                        class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-12 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-gray-600" required>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Instance -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">الرقم المرسل (Instance)</label>
                                    <div class="relative">
                                        <select name="instance_id" class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all appearance-none" required>
                                            @foreach($instances as $instance)
                                            <option value="{{ $instance->instance_id }}">{{ $instance->phone_number ?? $instance->instance_id }} ({{ $instance->status }})</option>
                                            @endforeach
                                            @if($instances->isEmpty())
                                            <option value="" disabled selected>لا توجد أرقام متصلة</option>
                                            @endif
                                        </select>
                                        <div class="absolute left-4 top-3.5 text-gray-500 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">المجموعة الدليل (Contacts)</label>
                                    <div class="relative">
                                        <select name="whatsapp_contact_id" class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all appearance-none" required>
                                            <option value="">-- اختر المجموعة --</option>
                                            @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->contact_name }} ({{ $group->numbers_count }} رقم)</option>
                                            @endforeach
                                            @if($groups->isEmpty())
                                            <option value="" disabled selected>لا توجد مجموعات</option>
                                            @endif
                                        </select>
                                        <div class="absolute left-4 top-3.5 text-gray-500 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Message Configuration -->
                    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/30 transition-all">
                        <div class="absolute top-0 right-0 w-1 h-full bg-purple-600 origin-top transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500"></div>

                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <span class="bg-purple-500/10 text-purple-400 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-mono border border-purple-500/20">02</span>
                            تكوين الرسائل
                        </h3>

                        <!-- Visual Selection Cards -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="message_mode" value="template" x-model="messageMode" class="peer sr-only">
                                <div class="bg-[#16161a] border border-gray-700/50 rounded-xl p-4 flex flex-col items-center gap-3 transition-all peer-checked:border-purple-500 peer-checked:bg-purple-500/5 hover:border-gray-500">
                                    <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 peer-checked:bg-purple-500 peer-checked:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-gray-300 peer-checked:text-purple-400">قالب محفوظ</span>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="message_mode" value="custom" x-model="messageMode" class="peer sr-only">
                                <div class="bg-[#16161a] border border-gray-700/50 rounded-xl p-4 flex flex-col items-center gap-3 transition-all peer-checked:border-purple-500 peer-checked:bg-purple-500/5 hover:border-gray-500">
                                    <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 peer-checked:bg-purple-500 peer-checked:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-gray-300 peer-checked:text-purple-400">رسالة مخصصة</span>
                                </div>
                            </label>
                        </div>

                        <!-- Template Mode -->
                        <div x-show="messageMode === 'template'" class="space-y-4 animate-fade-in-up">
                            <label class="block text-sm font-medium text-gray-300">اختر القالب</label>
                            <div class="relative">
                                <select name="whatsapp_message_id" class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all appearance-none">
                                    <option value="">-- اختر قالب الرسائل --</option>
                                    @foreach($templates as $template)
                                    <option value="{{ $template->id }}">
                                        {{ $template->name }} ({{ count($template->content ?? []) }} رسائل)
                                    </option>
                                    @endforeach
                                </select>
                                <div class="absolute left-4 top-3.5 text-gray-500 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Message Mode -->
                        <div x-show="messageMode === 'custom'" class="animate-fade-in-up">
                            <div x-data="{ messages: [''] }" class="space-y-6">

                                <div class="flex justify-between items-center">
                                    <label class="text-sm font-bold text-gray-300">نصوص الرسائل</label>
                                    <span class="text-xs text-purple-400 bg-purple-500/10 px-2 py-1 rounded border border-purple-500/20">سيتم التبديل عشوائياً بين الرسائل</span>
                                </div>

                                <div class="space-y-4">
                                    <template x-for="(msg, index) in messages" :key="index">
                                        <div class="relative group">
                                            <!-- Helper Buttons -->
                                            <div class="flex gap-2 mb-2 flex-wrap text-xs">
                                                <button type="button" @click="insertAtCursor($el.closest('.relative').querySelector('textarea'), '@{{random}}')"
                                                    class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded border border-gray-700 transition-colors flex items-center gap-1">
                                                    <span class="text-blue-400">@</span> نص عشوائي
                                                </button>
                                                <button type="button" @click="insertAtCursor($el.closest('.relative').querySelector('textarea'), '@{{welcome}}')"
                                                    class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded border border-gray-700 transition-colors flex items-center gap-1">
                                                    <span class="text-green-400">@</span> ترحيب
                                                </button>
                                                <button type="button" @click="insertAtCursor($el.closest('.relative').querySelector('textarea'), '@{{date}}')"
                                                    class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded border border-gray-700 transition-colors flex items-center gap-1">
                                                    <span class="text-yellow-400">@</span> التاريخ
                                                </button>
                                            </div>

                                            <textarea :name="'message[' + index + ']'" rows="4"
                                                x-model="messages[index]"
                                                @input="if(index===0) previewMessage = $event.target.value"
                                                placeholder="اكتب نص الرسالة هنا..."
                                                class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all resize-y min-h-[120px]"></textarea>

                                            <!-- Remove Button -->
                                            <button type="button" @click="messages.splice(index, 1)" x-show="messages.length > 1"
                                                class="absolute top-10 left-3 text-red-500 hover:text-red-400 bg-red-500/10 hover:bg-red-500/20 p-1.5 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <span class="absolute bottom-3 left-3 text-[10px] text-gray-600 font-mono" x-text="(messages[index] || '').length + ' char'"></span>
                                        </div>
                                    </template>
                                </div>

                                <button type="button" @click="if(messages.length < 10) messages.push('')" x-show="messages.length < 10"
                                    class="w-full border border-dashed border-gray-700 hover:border-purple-500 text-gray-400 hover:text-purple-400 font-medium py-3 rounded-xl transition-all flex items-center justify-center gap-2 hover:bg-purple-500/5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                    إضافة تغيير (Variation)
                                </button>
                            </div>

                            <!-- Media Attachment -->
                            <div class="mt-6 p-4 bg-[#16161a]/50 rounded-xl border border-dashed border-gray-700 hover:border-purple-500/50 transition-colors group">
                                <label class="flex items-center gap-4 cursor-pointer">
                                    <div class="w-12 h-12 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 group-hover:bg-purple-500/20 group-hover:text-purple-400 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-bold text-gray-300 group-hover:text-purple-400 transition-colors">إرفاق ملف أو صورة</div>
                                        <div class="text-xs text-gray-500 mt-1">يدعم الصور والمستندات بحد أقصى 10 ميجابايت</div>
                                    </div>
                                    <input type="file" name="media" class="hidden">
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Delays and Submit -->
                    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl p-6 relative overflow-hidden group hover:border-green-500/30 transition-all">
                        <div class="absolute top-0 right-0 w-1 h-full bg-green-600 origin-top transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500"></div>

                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <span class="bg-green-500/10 text-green-400 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-mono border border-green-500/20">03</span>
                            إعدادات الإرسال
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">الحد الأدنى (ثواني)</label>
                                <input type="number" name="min_delay" value="5" min="1" max="3600"
                                    class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white text-center font-mono focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">الحد الأقصى (ثواني)</label>
                                <input type="number" name="max_delay" value="15" min="1" max="3600"
                                    class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white text-center font-mono focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all">
                            </div>
                        </div>

                        <!-- Batch Sleep Settings -->
                        <div class="border border-gray-700/30 rounded-xl p-4 mb-6 bg-[#16161a]/50">
                            <h4 class="text-sm font-bold text-amber-400 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                حماية الرقم (استراحة بعد عدد معين)
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">عدد الرسائل قبل الاستراحة</label>
                                    <input type="number" name="batch_size" value="0" min="0" max="1000"
                                        class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white text-center font-mono focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all"
                                        placeholder="0 = بدون توقف">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">مدة الاستراحة (دقائق)</label>
                                    <input type="number" name="batch_sleep" value="0" min="0" max="120"
                                        class="w-full bg-[#16161a] border border-gray-700/50 rounded-xl px-4 py-3 text-white text-center font-mono focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all"
                                        placeholder="مثال: 5 دقائق">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">مثال: أرسل 20 رسالة ← استرح 5 دقائق ← أكمل. اتركه 0 لتعطيل هذه الميزة.</p>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-yellow-500 bg-yellow-500/5 p-3 rounded-lg border border-yellow-500/10 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            ينصح باستخدام فواصل زمنية عشوائية (مثل 15-45 ثانية) لتجنب الحظر.
                        </div>

                        <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span id="submitBtnText">إطلاق الحملة الآن</span>
                        </button>
                    </div>
                </div>

                <!-- Cost Summary Section -->
                <div class="space-y-6">
                    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">ملخص التكلفة</h3>

                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between items-center text-gray-400">
                                <span>عدد الأرقام المستهدفة:</span>
                                <span class="text-white font-mono" id="totalContacts">0</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-400">
                                <span>سعر الرسالة:</span>
                                <span class="text-white font-mono" id="pricePerMessage">0.00 ج.م</span>
                            </div>
                            <div class="border-t border-gray-700/50 my-2"></div>
                            <div class="flex justify-between items-center text-gray-200 font-bold text-lg">
                                <span>التكلفة الإجمالية:</span>
                                <span class="text-indigo-400" id="totalCost">0.00 ج.م</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-400">
                                <span>رصيدك الحالي:</span>
                                <span class="text-{{ auth()->user()->balance > 0 ? 'green' : 'red' }}-400 font-mono" id="currentBalance">{{ number_format(auth()->user()->balance, 2) }} ج.م</span>
                            </div>
                        </div>


    </form>
</div>
@endsection

@push('scripts')
<script>
    function insertAtCursor(myField, myValue) {
        if (myField.selectionStart || myField.selectionStart == '0') {
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
        myField.dispatchEvent(new Event('input'));
    }

    // Pricing Logic
    document.addEventListener('DOMContentLoaded', function() {
        const groupsSelect = document.querySelector('select[name="whatsapp_contact_id"]');

        // Safely pass data from Blade to JS
        const groupsData = @json($groups);
        const pricingTiers = @json($pricingTiers);
        const userBalance = parseFloat("{{ number_format(auth()->user()->balance, 2, '.', '') }}"); // Ensure pure number format

        console.log('Groups Data:', groupsData);
        console.log('Pricing Tiers:', pricingTiers);
        console.log('User Balance:', userBalance);

        const totalContactsEl = document.getElementById('totalContacts');
        const pricePerMessageEl = document.getElementById('pricePerMessage');
        const totalCostEl = document.getElementById('totalCost');
        const submitBtn = document.getElementById('submitBtn');
        const alertEl = document.getElementById('insufficientBalanceAlert'); // Assuming this element exists

        function calculateCost() {
            const selectedGroupId = groupsSelect.value;
            console.log('Selected Group ID:', selectedGroupId);

            // Check if tiers exist
            if (pricingTiers.length === 0) {
                console.warn('No pricing tiers configured.');
                pricePerMessageEl.textContent = 'غير محدد';
                totalCostEl.textContent = '0.00 ج.م';
                // Show specific alert for no pricing
                if (alertEl) {
                    alertEl.classList.remove('hidden');
                    alertEl.innerHTML = '<p class="text-red-400 text-xs text-center">عفواً، لم يتم تكوين شرائح الأسعار بعد.<br>يرجى التواصل مع الإدارة.</p>';
                }
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return;
            }

            // Reset if nothing selected
            if (!selectedGroupId) {
                totalContactsEl.textContent = '0';
                pricePerMessageEl.textContent = '0.00 ج.م';
                totalCostEl.textContent = '0.00 ج.م';
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                // Hide insufficient balance alert (which we might have repurposed)
                if (alertEl) alertEl.classList.add('hidden');
                return;
            }

            // Loose comparison to handle string/int ID mismatch
            const group = groupsData.find(g => g.id == selectedGroupId);
            if (!group) {
                console.warn('Group not found for ID:', selectedGroupId);
                return;
            }

            // Ensure count is an integer
            const count = parseInt(group.numbers_count || 0);
            totalContactsEl.textContent = count;
            console.log('Contact Count:', count);

            // Find Tier
            // Map and sort tiers by min_count DESC (Largest to Smallest)
            const sortedTiers = pricingTiers.map(t => ({
                ...t,
                min_count: parseInt(t.min_count),
                max_count: t.max_count ? parseInt(t.max_count) : null,
                price_per_message: parseFloat(t.price_per_message)
            })).sort((a, b) => b.min_count - a.min_count);

            console.log('Sorted Tiers (parsed):', sortedTiers);

            let matchingTier = sortedTiers.find(t => {
                const minCondition = t.min_count <= count;
                const maxCondition = t.max_count === null || t.max_count >= count;
                return minCondition && maxCondition;
            });

            console.log('Matching Tier:', matchingTier);

            let price = 0;
            if (matchingTier) {
                price = matchingTier.price_per_message;
            } else if (count > 0 && sortedTiers.length > 0) {
                // Fallback: If usage is smaller than the smallest tier min_count,
                // use the smallest tier price (last in desc sort).
                // e.g. Tiers start from 1000. Count is 8. Use tier 1000 price.
                const smallestTier = sortedTiers[sortedTiers.length - 1];
                price = smallestTier.price_per_message;
                console.log('Using smallest tier fallback price:', price);
            }

            pricePerMessageEl.textContent = price.toFixed(2) + ' ج.م';
            console.log('Price per message:', price);

            const total = count * price;
            totalCostEl.textContent = total.toFixed(2) + ' ج.م';
            console.log('Total Cost:', total);

            // Balance Check
            // Reset alert content first just in case
            if (alertEl) {
                alertEl.innerHTML = '<p class="text-red-400 text-xs text-center">رصيدك غير كافي لإطلاق هذه الحملة. <br><a href="{{ route("recharge") }}" class="underline font-bold hover:text-red-300">اشحن رصيدك الآن</a></p>';
            }

            if (total > userBalance) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                if (alertEl) alertEl.classList.remove('hidden');
                console.log('Insufficient balance.');
            } else {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                if (alertEl) alertEl.classList.add('hidden');
            }
        }

        groupsSelect.addEventListener('change', calculateCost);

        // Run once on load if something selected
        if (groupsSelect.value) {
            calculateCost();
        } else {
            // Ensure initial state is disabled if no group is selected
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            if (alertEl) alertEl.classList.add('hidden'); // Hide alert initially
        }
    });
</script>
@endpush
```
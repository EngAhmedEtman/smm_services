@extends('layouts.app')

@section('title', 'إضافة مجموعة أرقام | Etman SMM')

@section('content')
<div class="max-w-3xl mx-auto direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 left-0 w-[400px] h-[400px] bg-green-600/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800/80 rounded-3xl p-8 relative overflow-hidden shadow-2xl">

        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/5 rounded-bl-full pointer-events-none"></div>

        <div class="flex items-center gap-4 mb-8 relative z-10">
            <a href="{{ route('whatsapp.contacts') }}" class="w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center hover:bg-gray-800 transition-colors text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">إضافة مجموعة أرقام</h2>
                <p class="text-gray-400 text-sm">أنشئ قائمة جديدة لإرسال الحملات إليها</p>
            </div>
        </div>

        <form action="{{ route('whatsapp.contact.store') }}" method="POST" class="space-y-8 relative z-10">
            @csrf

            <!-- Contact Name -->
            <div class="group">
                <label for="contact_name" class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">اسم المجموعة / الحملة</label>
                <input type="text" name="contact_name" id="contact_name" required
                    class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-4 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-600 hover:bg-[#16161a]"
                    placeholder="مثال: عملاء الرياض - حملة رمضان">
            </div>

            <!-- Country Code Select -->
            <div class="group bg-[#16161a]/40 p-4 rounded-xl border border-dashed border-gray-700/50">
                <label for="country_code" class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">كود الدولة الافتراضي (اختياري)</label>
                <div class="relative">
                    <select name="country_code" class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all appearance-none cursor-pointer hover:bg-[#16161a] dir-ltr text-left">
                        <option value="">بدون كود افتراضي (الأرقام تتضمن الكود)</option>
                        <option value="20">+20 (مصر)</option>
                        <option value="966">+966 (السعودية)</option>
                        <option value="971">+971 (الإمارات)</option>
                        <option value="965">+965 (الكويت)</option>
                        <option value="1">+1 (أمريكا/كندا)</option>
                        <option value="44">+44 (بريطانيا)</option>
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    سيتم إضافة هذا الكود للأرقام التي لا تبدأ بـ + تلقائياً
                </p>
            </div>

            <!-- Phone Numbers Textarea -->
            <div class="group">
                <label for="phone_numbers" class="block text-sm font-bold text-gray-400 mb-2 transition-colors group-hover:text-green-500">أرقام الهواتف</label>
                <div class="relative">
                    <textarea name="phone_numbers" id="phone_numbers" rows="8" required
                        class="w-full bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all font-mono text-sm dir-ltr hover:bg-[#16161a] resize-y"
                        placeholder="2010xxxxxxxxx
9665xxxxxxxx
+1234567890"></textarea>
                    <div class="absolute bottom-3 left-3 opacity-20 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">اكتب كل رقم في سطر جديد. يمكنك نسخ ولصق مئات الأرقام هنا.</p>
            </div>

            <div class="pt-4 flex flex-col-reverse md:flex-row gap-4">
                <a href="{{ route('whatsapp.contacts') }}" class="px-6 py-3.5 rounded-xl border border-gray-600 text-gray-300 hover:bg-white/5 transition-all text-center font-bold">
                    إلغاء
                </a>
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-green-900/30 flex items-center justify-center gap-2 transform hover:-translate-y-1 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    حفظ المجموعة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
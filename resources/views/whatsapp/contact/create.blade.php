@extends('layouts.app')

@section('title', 'إضافة مجموعة أرقام | Etman SMM')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass p-8 rounded-2xl">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            إضافة مجموعة أرقام جديدة
        </h2>

        <form action="{{ route('whatsapp.contact.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Contact Name -->
            <div>
                <label for="contact_name" class="block text-sm font-medium text-gray-400 mb-2">اسم المجموعة / الحملة</label>
                <input type="text" name="contact_name" id="contact_name" required
                    class="w-full bg-[#16161a] border border-gray-700 rounded-lg py-2.5 px-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    placeholder="مثال: عملاء الرياض - حملة رمضان">
            </div>

            <!-- Country Code Select -->
            <div>
                <label for="country_code" class="block text-sm font-medium text-gray-400 mb-2">كود الدولة الافتراضي (اختياري)</label>
                <select name="country_code" class="w-full bg-[#16161a] border border-gray-700 rounded-lg py-2.5 px-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all dir-ltr text-left">
                    <option value="">بدون كود افتراضي (الأرقام تتضمن الكود)</option>
                    <option value="20">+20 (مصر)</option>
                    <option value="966">+966 (السعودية)</option>
                    <option value="971">+971 (الإمارات)</option>
                    <option value="965">+965 (الكويت)</option>
                    <option value="1">+1 (أمريكا/كندا)</option>
                    <option value="44">+44 (بريطانيا)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">سيتم إضافة هذا الكود للأرقام التي لا تبدأ بـ +</p>
            </div>

            <!-- Phone Numbers Textarea -->
            <div>
                <label for="phone_numbers" class="block text-sm font-medium text-gray-400 mb-2">أرقام الهواتف</label>
                <textarea name="phone_numbers" id="phone_numbers" rows="8" required
                    class="w-full bg-[#16161a] border border-gray-700 rounded-lg py-3 px-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-mono text-sm dir-ltr"
                    placeholder="2010xxxxxxxxx
9665xxxxxxxx
+1234567890"></textarea>
                <p class="text-xs text-gray-500 mt-2">اكتب كل رقم في سطر جديد. يمكنك نسخ ولصق مئات الأرقام هنا.</p>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-bold transition-all shadow-lg shadow-indigo-600/20">
                    حفظ المجموعة
                </button>
                <a href="{{ route('whatsapp.contacts') }}" class="px-6 py-2.5 rounded-lg border border-gray-600 text-gray-300 hover:bg-white/5 transition-all text-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
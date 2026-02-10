@extends('layouts.app')

@section('title', 'تعديل مجموعة الأرقام | Etman SMM')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass p-8 rounded-2xl">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            تعديل مجموعة الأرقام
        </h2>

        <form action="{{ route('whatsapp.contact.update', $contact->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Contact Name -->
            <div>
                <label for="contact_name" class="block text-sm font-medium text-gray-400 mb-2">اسم المجموعة / الحملة</label>
                <input type="text" name="contact_name" id="contact_name" required value="{{ old('contact_name', $contact->contact_name) }}"
                    class="w-full bg-[#16161a] border border-gray-700 rounded-lg py-2.5 px-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    placeholder="مثال: عملاء الرياض - حملة رمضان">
            </div>

            <!-- Country Code Select -->
            <div>
                <label for="country_code" class="block text-sm font-medium text-gray-400 mb-2">كود الدولة الافتراضي (اختياري للأرقام الجديدة أو المعدلة)</label>
                <select name="country_code" class="w-full bg-[#16161a] border border-gray-700 rounded-lg py-2.5 px-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all dir-ltr text-left">
                    <option value="">بدون تغيير (احتفاظ بالأرقام كما هي)</option>
                    <option value="20">+20 (مصر)</option>
                    <option value="966">+966 (السعودية)</option>
                    <option value="971">+971 (الإمارات)</option>
                    <option value="965">+965 (الكويت)</option>
                    <option value="1">+1 (أمريكا/كندا)</option>
                    <option value="44">+44 (بريطانيا)</option>
                </select>
                <p class="text-xs text-yellow-500 mt-1">تنبيه: الكود المحدد سيتم إضافته فقط للأرقام التي لا تبدأ بـ + (عند الحفظ).</p>
            </div>

            <!-- Phone Numbers Textarea -->
            <div>
                <label for="phone_numbers" class="block text-sm font-medium text-gray-400 mb-2">أرقام الهواتف</label>
                <textarea name="phone_numbers" id="phone_numbers" rows="8" required
                    class="w-full bg-[#16161a] border border-gray-700 rounded-lg py-3 px-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-mono text-sm dir-ltr"
                    placeholder="2010xxxxxxxxx">{{ old('phone_numbers', $numbersString) }}</textarea>
                <p class="text-xs text-gray-400 mt-2">يمكنك تعديل القائمة، حذف أرقام، أو إضافة أرقام جديدة. <br> <span class="text-red-400">أي تعديل هنا سيستبدل القائمة القديمة بالكامل عند الحفظ.</span></p>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-bold transition-all shadow-lg shadow-indigo-600/20">
                    حفظ التعديلات
                </button>
                <a href="{{ route('whatsapp.contacts') }}" class="px-6 py-2.5 rounded-lg border border-gray-600 text-gray-300 hover:bg-white/5 transition-all text-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.packages.index') }}"
            class="text-pink-400 hover:text-pink-300 inline-flex items-center gap-2 mb-4">
            ← رجوع للقائمة
        </a>
        <h1 class="text-3xl font-bold text-white">إضافة باقة جديدة</h1>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl p-8 border border-gray-700 max-w-2xl">
        <form action="{{ route('admin.packages.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">اسم الباقة</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-pink-500 transition-colors"
                    placeholder="مثال: الباقة الذهبية">
                @error('name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">عدد الرسائل</label>
                <input type="number" name="message_limit" value="{{ old('message_limit') }}" required min="1"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-pink-500 transition-colors"
                    placeholder="1000">
                @error('message_limit')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">السعر (ج.م)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required min="0"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-pink-500 transition-colors"
                    placeholder="100.00">
                @error('price')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">المدة (بالأيام)</label>
                <input type="number" name="duration_days" value="{{ old('duration_days', 30) }}" required min="1"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-pink-500 transition-colors"
                    placeholder="30">
                @error('duration_days')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 text-pink-500 bg-gray-700 border-gray-600 rounded focus:ring-pink-500">
                    <span class="text-gray-200 font-semibold">الباقة فعالة</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                    حفظ الباقة
                </button>
                <a href="{{ route('admin.packages.index') }}"
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition-all">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
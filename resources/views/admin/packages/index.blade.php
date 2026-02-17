@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">إدارة باقات WhatsApp</h1>
        <a href="{{ route('admin.packages.create') }}"
            class="bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
            + إضافة باقة جديدة
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border border-gray-700">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-pink-500/20 to-purple-600/20">
                <tr>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">#</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">اسم الباقة</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">عدد الرسائل</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">السعر</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">المدة (أيام)</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">الحالة</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-200">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($packages as $package)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-gray-300">{{ $package->id }}</td>
                    <td class="px-6 py-4 text-white font-semibold">{{ $package->name }}</td>
                    <td class="px-6 py-4 text-gray-300">{{ number_format($package->message_limit) }} رسالة</td>
                    <td class="px-6 py-4 text-green-400 font-bold">{{ number_format($package->price, 2) }} ج.م</td>
                    <td class="px-6 py-4 text-gray-300">{{ $package->duration_days }} يوم</td>
                    <td class="px-6 py-4">
                        @if($package->is_active)
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">فعالة</span>
                        @else
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm">معطلة</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('admin.packages.edit', $package->id) }}"
                                class="px-4 py-2 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 rounded-lg transition-all">
                                تعديل
                            </a>
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500/30 rounded-lg transition-all">
                                    حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center gap-4">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-lg">لا توجد باقات حالياً</p>
                            <a href="{{ route('admin.packages.create') }}"
                                class="text-pink-400 hover:text-pink-300 underline">
                                أضف باقة جديدة
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
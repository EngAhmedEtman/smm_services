@extends('layouts.app')

@section('title', 'إعدادات تسعير رسائل الواتساب')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">شرائح تسعير رسائل الواتساب</h2>
            <button onclick="document.getElementById('addTierModal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-200">
                إضافة شريحة جديدة
            </button>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                من (عدد رسائل)
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                إلى (عدد رسائل)
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                السعر للرسالة
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                إجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tiers as $tier)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">{{ $tier->min_count }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                                    {{ $tier->max_count ?? 'فأكثر' }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">{{ $tier->price_per_message }} ج.م</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm flex gap-2">
                                <button onclick="editTier({{ $tier }})" class="text-blue-600 hover:text-blue-900">تعديل</button>
                                <form action="{{ route('admin.pricing.destroy', $tier) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Tier Modal -->
<div id="addTierModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">إضافة شريحة جديدة</h3>
            <form action="{{ route('admin.pricing.store') }}" method="POST" class="mt-2 text-right">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">من (الحد الأدنى)</label>
                    <input type="number" name="min_count" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">إلى (الحد الأقصى - اتركه فارغاً لللانهاية)</label>
                    <input type="number" name="max_count" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-white">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">السعر للرسالة</label>
                    <input type="number" step="0.01" name="price_per_message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('addTierModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">إلغاء</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Tier Modal (Simplified) -->
<div id="editTierModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">تعديل الشريحة</h3>
            <form id="editTierForm" method="POST" class="mt-2 text-right">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">من (الحد الأدنى)</label>
                    <input type="number" id="edit_min_count" name="min_count" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">إلى (الحد الأقصى)</label>
                    <input type="number" id="edit_max_count" name="max_count" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-white">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">السعر للرسالة</label>
                    <input type="number" step="0.01" id="edit_price" name="price_per_message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('editTierModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">إلغاء</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editTier(tier) {
        document.getElementById('editTierModal').classList.remove('hidden');
        document.getElementById('edit_min_count').value = tier.min_count;
        document.getElementById('edit_max_count').value = tier.max_count;
        document.getElementById('edit_price').value = tier.price_per_message;
        document.getElementById('editTierForm').action = "/admin/pricing/" + tier.id;
    }
</script>
@endsection
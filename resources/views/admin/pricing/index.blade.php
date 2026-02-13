@extends('layouts.app')

@section('title', 'إعدادات تسعير رسائل الواتساب')
@section('header_title', 'تسعير الواتساب')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex justify-between items-center bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl">
        <div>
            <h2 class="text-xl font-bold text-white mb-1">شرائح تسعير الرسائل</h2>
            <p class="text-gray-400 text-sm">تحكم في تكلفة الرسائل بناءً على حجم الاستهلاك.</p>
        </div>
        <button onclick="document.getElementById('addTierModal').classList.remove('hidden')"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            إضافة شريحة جديدة
        </button>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-4 rounded-xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-6 py-4 rounded-xl">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Tiers Table -->
    <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-gray-800/50 text-gray-400 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">الحد الأدنى (رسائل)</th>
                        <th class="px-6 py-4 font-medium">الحد الأقصى (رسائل)</th>
                        <th class="px-6 py-4 font-medium">السعر (لكل رسالة)</th>
                        <th class="px-6 py-4 font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($tiers as $tier)
                    <tr class="hover:bg-gray-800/30 transition-colors group">
                        <td class="px-6 py-4 text-white font-mono text-lg">
                            <span class="bg-indigo-500/10 text-indigo-400 px-3 py-1 rounded-lg border border-indigo-500/20">
                                {{ number_format($tier->min_count) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-white font-mono text-lg">
                            @if($tier->max_count)
                            <span class="bg-purple-500/10 text-purple-400 px-3 py-1 rounded-lg border border-purple-500/20">
                                {{ number_format($tier->max_count) }}
                            </span>
                            @else
                            <span class="text-gray-500 italic">بـلا حـد (فأكثر)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-emerald-400 font-bold text-lg">
                            {{ number_format($tier->price_per_message, 2) }} <span class="text-xs text-gray-500 font-normal">ج.م</span>
                        </td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <button onclick='editTier(@json($tier))' class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all" title="تعديل">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                            <form action="{{ route('admin.pricing.destroy', $tier) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الشريحة؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all" title="حذف">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>لا توجد شرائح تسعير مضافة بعد.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Tier Modal -->
<div id="addTierModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">إضافة شريحة جديدة</h3>
            <p class="text-gray-400 text-sm mt-1">حدد نطاق الرسائل والسعر المناسب.</p>
        </div>

        <form action="{{ route('admin.pricing.store') }}" method="POST" class="space-y-4 text-right">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">من (الحد الأدنى)</label>
                <input type="number" name="min_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required placeholder="0">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">إلى (الحد الأقصى - اختياري)</label>
                <input type="number" name="max_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="اتركه فارغاً لجعله مفتوحاً">
                <p class="text-xs text-gray-600 mt-1">مثال: 1000. إذا تركته فارغاً سيعني "فأكثر".</p>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للرسالة (ج.م)</label>
                <input type="number" step="0.01" name="price_per_message" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required placeholder="0.50">
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addTierModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20">حفظ الشريحة</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Tier Modal -->
<div id="editTierModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">تعديل الشريحة</h3>
        </div>

        <form id="editTierForm" method="POST" class="space-y-4 text-right">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">من (الحد الأدنى)</label>
                <input type="number" id="edit_min_count" name="min_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">إلى (الحد الأقصى)</label>
                <input type="number" id="edit_max_count" name="max_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للرسالة (ج.م)</label>
                <input type="number" step="0.01" id="edit_price" name="price_per_message" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('editTierModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20">تحديث</button>
            </div>
        </form>
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
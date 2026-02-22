@extends('layouts.app')

@section('title', 'الخدمات المخصصة | Etman SMM')
@section('header_title', 'الخدمات المخصصة')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                الخدمات المخصصة
            </h1>
            <p class="text-gray-400 mt-1">إدارة الخدمات المحلية الخاصة بك والتي لا ترتبط بمزود خارجي</p>
        </div>
        <span class="bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold px-3 py-1.5 rounded-full">
            🔒 Super Admin
        </span>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="glass border border-green-500/30 p-4 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-green-400 text-sm flex-1">{{ session('success') }}</p>
        <button @click="show = false" class="text-gray-500 hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Custom Services Section --}}
    <div>
        <div class="flex justify-between items-center mb-6 mt-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="w-1 h-8 bg-pink-500 rounded-full"></span>
                قائمة الخدمات المخصصة
            </h2>
            <button onclick="document.getElementById('addCustomServiceModal').classList.remove('hidden')"
                class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-pink-600/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                إضافة خدمة مخصصة
            </button>
        </div>

        <div class="glass overflow-hidden rounded-2xl border border-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gray-800/50 text-gray-400 text-sm uppercase tracking-wider">
                            <th class="px-6 py-4 font-medium">القسم</th>
                            <th class="px-6 py-4 font-medium">اسم الخدمة</th>
                            <th class="px-6 py-4 font-medium">السعر (للألف)</th>
                            <th class="px-6 py-4 font-medium">الكمية (أدني - أقصي)</th>
                            <th class="px-6 py-4 font-medium">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($customServices ?? [] as $service)
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="px-6 py-4 text-white">
                                <span class="bg-gray-700/50 px-3 py-1 rounded-lg text-sm">{{ $service->category }}</span>
                            </td>
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4 text-emerald-400 font-bold">
                                {{ number_format($service->rate, 4) }} <span class="text-xs text-gray-500 font-normal">$</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300 font-mono text-sm">
                                {{ number_format($service->min) }} - {{ number_format($service->max) }}
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <button onclick='openEditModal({!! json_encode([
                                    "id" => $service->id,
                                    "name" => $service->name,
                                    "category" => $service->category,
                                    "description" => $service->description,
                                    "rate" => $service->rate,
                                    "min" => $service->min,
                                    "max" => $service->max
                                ]) !!})' class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all" title="تعديل">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.customServices.destroy', $service->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟');">
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
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p>لا توجد خدمات مخصصة مضافة بعد.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Custom Service Modal -->
<div id="addCustomServiceModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">إضافة خدمة مخصصة</h3>
            <p class="text-gray-400 text-sm mt-1">أدخل بيانات الخدمة الجديدة.</p>
        </div>

        <form action="{{ route('admin.customServices.store') }}" method="POST" class="space-y-4 text-right">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">اسم القسم</label>
                <select name="category" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required>
                    <option value="" disabled selected>-- اختر القسم --</option>
                    @foreach($mainCategories ?? [] as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">اسم الخدمة</label>
                <input type="text" name="name" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="اسم الخدمة">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">الوصف</label>
                <textarea name="description" rows="3" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all placeholder-gray-500" required placeholder="وصف الخدمة المخصصة..."></textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للألف ($)</label>
                <input type="number" step="0.0001" name="rate" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="1.50">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-400 text-sm font-bold mb-2">الحد الأدنى</label>
                    <input type="number" name="min" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="10">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm font-bold mb-2">الحد الأقصى</label>
                    <input type="number" name="max" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="10000">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addCustomServiceModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-pink-600/20">حفظ الخدمة</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Custom Service Modal -->
<div id="editCustomServiceModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">تعديل الخدمة المخصصة</h3>
            <p class="text-gray-400 text-sm mt-1">تحديث بيانات الخدمة الحالية.</p>
        </div>

        <form id="editCustomServiceForm" method="POST" class="space-y-4 text-right">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">اسم القسم</label>
                <select name="category" id="edit_category" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required>
                    <option value="" disabled>-- اختر القسم --</option>
                    @foreach($mainCategories ?? [] as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">اسم الخدمة</label>
                <input type="text" name="name" id="edit_name" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">الوصف</label>
                <textarea name="description" id="edit_description" rows="3" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all placeholder-gray-500" required></textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للألف ($)</label>
                <input type="number" step="0.0001" name="rate" id="edit_rate" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-400 text-sm font-bold mb-2">الحد الأدنى</label>
                    <input type="number" name="min" id="edit_min" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm font-bold mb-2">الحد الأقصى</label>
                    <input type="number" name="max" id="edit_max" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('editCustomServiceModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20">حفظ التحديث</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(service) {
        document.getElementById('edit_name').value = service.name;
        document.getElementById('edit_category').value = service.category;
        document.getElementById('edit_description').value = service.description;
        document.getElementById('edit_rate').value = service.rate;
        document.getElementById('edit_min').value = service.min;
        document.getElementById('edit_max').value = service.max;

        document.getElementById('editCustomServiceForm').action = '/admin/custom-services/' + service.id;
        document.getElementById('editCustomServiceModal').classList.remove('hidden');
    }
</script>
@endsection
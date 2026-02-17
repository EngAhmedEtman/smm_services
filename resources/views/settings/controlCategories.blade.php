@extends('layouts.app')

@section('title', 'التحكم في الأقسام')

@section('content')
<div class="min-h-screen bg-[#16161a] py-8 px-4 sm:px-6 lg:px-8 dir-rtl">
    <div class="max-w-[95%] mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                    <span class="text-red-600">|</span> التحكم في الأقسام
                </h1>
                <p class="mt-2 text-gray-400 text-sm">تخصيص وترتيب الأقسام وربطها بالأقسام الرئيسية</p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.controlCategories.index') }}" method="GET" class="flex items-center">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث عن قسم..."
                        class="w-64 bg-[#1e1e24] border border-gray-700 rounded-xl px-4 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    @if(request('search'))
                    <a href="{{ route('admin.controlCategories.index') }}" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    @endif
                </div>
                <button type="submit" class="mr-2 bg-blue-600 hover:bg-blue-500 text-white p-2 rounded-xl shadow-lg transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Main Categories Management Section -->
        <div class="mb-12 bg-[#1e1e24] rounded-2xl shadow-2xl border border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="text-blue-500">#</span> الأقسام الرئيسية (الترتيب العام)
                </h2>
                <button onclick="document.getElementById('addMainCategoryModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-xl shadow-lg transition-all flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>إضافة قسم رئيسي</span>
                </button>
            </div>

            <form action="{{ route('admin.controlCategories.updateMainList') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/80">
                            <tr>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-10">#</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">اسم القسم</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider w-32">الترتيب</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider w-24">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50 bg-[#1e1e24]">
                            @forelse($mainCategories as $mainCat)
                            <tr class="group hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $mainCat->id }}</td>
                                <td class="px-6 py-4">
                                    <input type="text" name="main_categories[{{ $mainCat->id }}][name]" value="{{ $mainCat->name }}"
                                        class="w-full bg-[#16161a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="number" name="main_categories[{{ $mainCat->id }}][sort_order]" value="{{ $mainCat->sort_order }}"
                                        class="w-20 text-center bg-[#16161a] border border-gray-700 rounded-lg px-2 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" onclick="confirmDeleteMain({{ $mainCat->id }})" class="text-gray-500 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">لا توجد أقسام رئيسية بعد.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($mainCategories->count() > 0)
                <div class="p-4 bg-gray-800/30 border-t border-gray-700 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-xl shadow-lg shadow-blue-900/20 transition-all text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        حفظ تغييرات الأقسام الرئيسية
                    </button>
                </div>
                @endif
            </form>
        </div>

        <!-- Sub Categories Section -->
        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <span class="text-red-500">#</span> الأقسام الفرعية (ربط الخدمات)
        </h2>

        <div class="bg-[#1e1e24] rounded-2xl shadow-2xl border border-gray-800 overflow-hidden">
            <form action="{{ route('control-categories.update') }}" method="POST">
                @csrf

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/80">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-1/3">القسم الأصلي (API)</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider w-20">
                                    <div class="flex flex-col items-center gap-1">
                                        <span>الحالة</span>
                                        <input type="checkbox" id="selectAll" class="w-4 h-4 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500 focus:ring-2 cursor-pointer" title="تحديد/إلغاء تحديد الكل">
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-1/3">القسم الرئيسي</th>
                                <!-- Custom Name Column Removed -->
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider w-24">الترتيب</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50 bg-[#1e1e24]">
                            @forelse ($categories as $cat)
                            <tr class="group hover:bg-gray-800/50 transition-colors duration-150 {{ $loop->even ? 'bg-[#1a1a20]' : '' }}">
                                <td class="px-6 py-4 text-sm text-gray-300 font-medium dir-ltr text-right">
                                    {{ $cat['original_name'] }}
                                    <input type="hidden" name="categories[{{ $loop->index }}][original_name]" value="{{ $cat['original_name'] }}">
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center items-center">
                                        <input type="checkbox" name="categories[{{ $loop->index }}][active]" value="1"
                                            class="cat-active-checkbox w-6 h-6 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500 focus:ring-2 cursor-pointer transition-all hover:scale-110"
                                            {{ $cat['is_active'] ? 'checked' : '' }}>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <select name="categories[{{ $loop->index }}][main_category_id]"
                                        class="w-full bg-[#16161a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all shadow-sm">
                                        <option value="">-- اختر --</option>
                                        @foreach($mainCategories as $mainCat)
                                        <option value="{{ $mainCat->id }}" {{ $cat['main_category_id'] == $mainCat->id ? 'selected' : '' }}>
                                            {{ $mainCat->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Custom Name Input Removed -->

                                <td class="px-6 py-4 text-center">
                                    <input type="number" name="categories[{{ $loop->index }}][sort_order]"
                                        value="{{ $cat['sort_order'] }}"
                                        class="w-20 text-center bg-[#16161a] border border-gray-700 rounded-lg px-2 py-2 text-sm text-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all shadow-sm">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    لا توجد أقسام متاحة.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-700/50">
                    {{ $categories->links() }}
                </div>

                <div class="p-6 bg-gray-800/30 border-t border-gray-700 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-900/20 transition-all duration-200 hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Form (Hidden) -->
        <form id="deleteMainForm" action="" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function confirmDeleteMain(id) {
                if (confirm('هل أنت متأكد من حذف هذا القسم الرئيسي؟ لن يؤثر ذلك على الخدمات، ولكن سيتم فك ارتباط الأقسام الفرعية التابعة له.')) {
                    const form = document.getElementById('deleteMainForm');
                    form.action = "{{ route('admin.controlCategories.destroyMain', 0) }}".replace('/0', '/' + id);
                    form.submit();
                }
            }
        </script>
    </div>
</div>

<!-- Modal for Main Category -->
<div id="addMainCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('addMainCategoryModal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-[#1e1e24] rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700">
            <form action="{{ route('control-categories.store-main') }}" method="POST">
                @csrf
                <div class="bg-[#1e1e24] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-right w-full">
                            <h3 class="text-lg leading-6 font-medium text-white mb-4" id="modal-title">
                                إضافة قسم رئيسي جديد
                            </h3>
                            <div class="mt-2">
                                <label for="main_cat_name" class="block text-sm font-medium text-gray-400 mb-2">اسم القسم</label>
                                <input type="text" name="name" id="main_cat_name" required
                                    class="w-full bg-[#16161a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-600 shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        حفظ
                    </button>
                    <button type="button" onclick="document.getElementById('addMainCategoryModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.cat-active-checkbox');

        // Toggle all checkboxes when Master is clicked
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });

        // Update Master checkbox state when any child is clicked
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // Check if all are checked
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
    });
</script>
@endsection
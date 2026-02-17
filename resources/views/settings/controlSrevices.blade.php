@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
                {{ __('Control Services') }}
            </h2>
            <button type="submit" form="servicesForm" class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-red-900/20 transition-all duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                {{ __('Save Changes') }}
            </button>
        </div>

        @if (session('success'))
        <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-xl mb-6 flex items-center gap-3 backdrop-blur-sm" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-[#1e1e24] overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-700/50">
            <div class="p-6">

                <form id="servicesForm" action="{{ route('admin.controlServices.update') }}" method="POST">
                    @csrf

                    <div class="overflow-x-auto rounded-xl border border-gray-700/50">
                        <table class="min-w-full divide-y divide-gray-700/50">
                            <thead class="bg-gray-800/80">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-16">ID</th>
                                    <th scope="col" class="px-3 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider w-24">
                                        <div class="flex flex-col items-center gap-1">
                                            <span>Status</span>
                                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500 focus:ring-2 cursor-pointer" title="تحديد/إلغاء تحديد الكل في هذه الصفحة">
                                        </div>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-24">Original Cat</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-5/12">Custom Category</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Service Name</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-24">Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50 bg-[#1e1e24]">
                                @forelse ($services as $service)
                                <tr class="group hover:bg-gray-800/50 transition-colors duration-150 {{ $loop->even ? 'bg-[#1a1a20]' : '' }}">
                                    <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500 font-mono">
                                        {{ $service['service'] }}
                                        <input type="hidden" name="services[{{ $service['service'] }}][name]" value="{{ $service['name'] }}">
                                        <input type="hidden" name="services[{{ $service['service'] }}][rate]" value="{{ $service['rate'] }}">
                                        <input type="hidden" name="services[{{ $service['service'] }}][min]" value="{{ $service['min'] }}">
                                        <input type="hidden" name="services[{{ $service['service'] }}][max]" value="{{ $service['max'] }}">
                                        <input type="hidden" name="services[{{ $service['service'] }}][original_category]" value="{{ $service['original_category'] ?? $service['category'] }}">
                                    </td>

                                    <td class="px-3 py-3 whitespace-nowrap text-center">
                                        <div class="flex justify-center items-center">
                                            <input type="checkbox" name="services[{{ $service['service'] }}][active]" value="1"
                                                class="service-active-checkbox w-6 h-6 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500 focus:ring-2 cursor-pointer transition-all hover:scale-110"
                                                {{ ($service['is_active'] ?? true) ? 'checked' : '' }}>
                                        </div>
                                    </td>

                                    <td class="px-3 py-3 text-xs text-gray-400 whitespace-normal">
                                        <div class="line-clamp-2" title="{{ $service['original_category'] ?? $service['category'] }}">
                                            {{ $service['original_category'] ?? $service['category'] }}
                                        </div>
                                    </td>

                                    <td class="px-3 py-3">
                                        <textarea name="services[{{ $service['service'] }}][custom_category]"
                                            rows="2"
                                            placeholder="تخصيص اسم القسم"
                                            class="w-full bg-[#16161a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all placeholder-gray-600 shadow-sm focus:shadow-md resize-none">{{ isset($service['original_category']) ? $service['category'] : '' }}</textarea>
                                    </td>

                                    <td class="px-3 py-3 text-xs text-gray-300">
                                        <div class="line-clamp-2" title="{{ $service['name'] }}">
                                            {{ $service['name'] }}
                                        </div>
                                    </td>

                                    <td class="px-3 py-3 whitespace-nowrap text-xs font-mono text-emerald-400 font-bold">
                                        ${{ number_format($service['rate'], 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <p>لا توجد خدمات متاحة لعرضها.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $services->links() }}
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-900/20 transition-all duration-200 hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Save Changes') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const serviceCheckboxes = document.querySelectorAll('.service-active-checkbox');

        // Toggle all checkboxes when Master is clicked
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            serviceCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });

        // Update Master checkbox state when any child is clicked
        serviceCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // Check if all are checked
                    const allChecked = Array.from(serviceCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        // Initial check: if all loaded items are checked, check the master
        if (serviceCheckboxes.length > 0) {
            const allChecked = Array.from(serviceCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
        }
    });
</script>
@endsection
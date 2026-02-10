@extends('layouts.app')

@section('title', 'المفضلة | Etman SMM')
@section('header_title', 'الخدمات المفضلة')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="glass rounded-2xl overflow-hidden shadow-2xl border border-gray-800 mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right">
                <thead class="bg-gray-900/80 text-gray-400 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">الخدمة</th>
                        <th class="px-6 py-4">الفئة</th>
                        <th class="px-6 py-4">السعر / 1000</th>
                        <th class="px-6 py-4">الحدود</th>
                        <th class="px-6 py-4 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($favoriteServices as $service)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 font-mono text-indigo-400 font-bold">#{{ $service['service'] }}</td>

                        <td class="px-6 py-4 max-w-md">
                            <p class="text-white font-medium mb-1">{{ $service['name'] }}</p>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] bg-gray-700 text-gray-300">{{ $service['type'] }}</span>
                        </td>

                        <td class="px-6 py-4 text-gray-400 text-xs">
                            {{ $service['category'] }}
                        </td>

                        <td class="px-6 py-4 font-mono text-green-400 font-bold whitespace-nowrap">
                            {{ number_format($service['rate'], 4) }} ج.م
                        </td>

                        <td class="px-6 py-4 text-gray-400 font-mono text-xs whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <span>Min: <span class="text-gray-300">{{ $service['min'] }}</span></span>
                                <span>Max: <span class="text-gray-300">{{ $service['max'] }}</span></span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center flex items-center justify-center gap-2">
                            <!-- Helper Object for Modal -->
                            @php
                            $serviceObj = [
                            'service' => $service['service'],
                            'name' => $service['name'],
                            'rate' => $service['rate'],
                            'min' => $service['min'],
                            'max' => $service['max'],
                            'type' => $service['type']
                            ];
                            @endphp
                            <button onclick="openOrderModal({{ json_encode($serviceObj) }})" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-lg hover:shadow-indigo-500/20 whitespace-nowrap">
                                طلب
                            </button>
                            <button onclick="toggleFavorite(this, {{ json_encode($serviceObj) }})" class="text-yellow-400 hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            لا توجد خدمات مفضلة حتى الآن.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Order Modal -->
<div id="orderModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity duration-300" x-data x-cloak>
    <div class="bg-[#1e1e24] border border-gray-700 rounded-2xl p-6 md:p-8 max-w-md w-full mx-4 shadow-2xl relative">
        <button onclick="closeOrderModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-xl font-bold text-white mb-1">طلب خدمة جديدة</h2>
        <p id="modalServiceName" class="text-indigo-400 text-sm mb-6 font-medium truncate"></p>

        <form id="quickOrderForm" class="space-y-4" onsubmit="submitQuickOrder(event)">
            @csrf
            <input type="hidden" name="service" id="modalServiceId">
            <input type="hidden" id="modalServiceRate">
            <input type="hidden" name="charge" id="modalChargeInput">

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">الرابط</label>
                <input type="url" name="link" required class="form-input block w-full rounded-lg bg-gray-800 border-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="https://example.com/post">
            </div>

            <div id="modalQuantityContainer">
                <label class="block text-sm font-medium text-gray-400 mb-2">الكمية</label>
                <input type="number" name="quantity" id="modalQuantity" required class="form-input block w-full rounded-lg bg-gray-800 border-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="مثال: 1000">
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>Min: <span id="modalMin">0</span></span>
                    <span>Max: <span id="modalMax">0</span></span>
                </div>
            </div>

            <div id="modalCommentsContainer" class="hidden">
                <label class="block text-sm font-medium text-gray-400 mb-2">التعليقات</label>
                <textarea name="comments" id="modalComments" rows="5" class="form-input block w-full rounded-lg bg-gray-800 border-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="اكتب تعليقاتك هنا..."></textarea>
                <p class="text-xs text-gray-500 mt-1">إجمالي التعليقات: <span id="modalCommentsCount" class="font-bold text-indigo-400">0</span></p>
            </div>

            <!-- Total Price Preview -->
            <div class="bg-indigo-900/20 border border-indigo-500/20 rounded-xl p-3 flex justify-between items-center">
                <span class="text-sm text-gray-400">التكلفة المتوقعة:</span>
                <span id="modalTotalPrice" class="text-lg font-bold text-white font-mono">0.00 ج.م</span>
            </div>

            <button type="submit" id="btnSubmit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-colors flex justify-center gap-2 items-center">
                <span>تأكيد الطلب</span>
                <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toast Notification System
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const colors = {
            success: 'bg-gray-900 border-l-4 border-green-500 text-white shadow-2xl shadow-green-900/20',
            error: 'bg-gray-900 border-l-4 border-red-500 text-white shadow-2xl shadow-red-900/20',
            warning: 'bg-gray-900 border-l-4 border-yellow-500 text-white shadow-2xl shadow-yellow-900/20',
            info: 'bg-gray-900 border-l-4 border-blue-500 text-white shadow-2xl shadow-blue-900/20'
        };

        const icons = {
            success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
            info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        };

        toast.className = `fixed top-4 right-4 z-[100] ${colors[type]} border rounded-xl p-4 shadow-2xl transform transition-all duration-300 flex items-center gap-3 max-w-md animate-slide-in`;
        toast.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                ${icons[type]}
            </svg>
            <span class="flex-1 text-sm">${message}</span>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    function toggleFavorite(btn, service) {
        // Optimistic UI
        const row = btn.closest('tr');
        row.style.opacity = '0.5';

        fetch("{{ route('services.makeFavorite') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    service_id: service.service,
                    name: service.name,
                    rate: service.rate,
                    min: service.min,
                    max: service.max,
                    category: service.category || 'Default',
                    type: service.type || 'Default'
                })
            })
            .then(res => res.json())
            .then(data => {
                // If we are strictly removing
                row.remove();
                if (document.querySelector('tbody').children.length === 0) {
                    location.reload();
                }
                showToast('تم إزالة الخدمة من المفضلة', 'success');
            })
            .catch(err => {
                console.error(err);
                row.style.opacity = '1';
                showToast('حدث خطأ أثناء تحديث المفضلة', 'error');
            });
    }

    // Modal Logic
    const modal = document.getElementById('orderModal');
    const modalServiceName = document.getElementById('modalServiceName');
    const modalServiceId = document.getElementById('modalServiceId');
    const modalServiceRate = document.getElementById('modalServiceRate');
    const modalQuantity = document.getElementById('modalQuantity');
    const modalComments = document.getElementById('modalComments');
    const modalQuantityContainer = document.getElementById('modalQuantityContainer');
    const modalCommentsContainer = document.getElementById('modalCommentsContainer');
    const modalMin = document.getElementById('modalMin');
    const modalMax = document.getElementById('modalMax');
    const modalTotal = document.getElementById('modalTotalPrice');
    const modalChargeInput = document.getElementById('modalChargeInput');
    const btnSubmit = document.getElementById('btnSubmit');
    const spinner = document.getElementById('loadingSpinner');

    function openOrderModal(service) {
        modalServiceName.textContent = service.service + ' - ' + service.name;
        modalServiceId.value = service.service; // External ID
        modalServiceRate.value = service.rate;
        modalMin.textContent = service.min;
        modalMax.textContent = service.max;

        document.getElementById('quickOrderForm').reset();
        modalServiceId.value = service.service;
        modalTotal.textContent = '0.00 ج.م';
        modalChargeInput.value = 0;

        handleModalType(service.type);

        modal.classList.remove('hidden');
    }

    function closeOrderModal() {
        modal.classList.add('hidden');
    }

    modalQuantity.addEventListener('input', calculateModalPrice);
    modalComments.addEventListener('input', calculateModalPrice);

    function handleModalType(type) {
        // Reset
        modalQuantityContainer.classList.remove('hidden');
        modalCommentsContainer.classList.add('hidden');
        modalQuantity.readOnly = false;

        if (type === 'Custom Comments' || type === 'Custom Comments Package') {
            modalQuantityContainer.classList.add('hidden');
            modalCommentsContainer.classList.remove('hidden');
        } else if (type === 'Package') {
            modalQuantity.value = 1;
            modalQuantity.readOnly = true;
        }
    }

    function calculateModalPrice() {
        const isCustom = !modalCommentsContainer.classList.contains('hidden');

        let qty = parseFloat(modalQuantity.value);
        if (isCustom) {
            const lines = modalComments.value.split(/\r\n|\r|\n/).filter(line => line.trim() !== '');
            qty = lines.length;
            modalQuantity.value = qty;
            const countEl = document.getElementById('modalCommentsCount');
            if (countEl) countEl.textContent = qty;
        }

        const rate = parseFloat(modalServiceRate.value);

        if (qty > 0 && rate > 0) {
            const total = (qty / 1000) * rate;
            modalTotal.textContent = total.toFixed(4) + ' ج.م';
            modalChargeInput.value = total.toFixed(4);
        } else {
            modalTotal.textContent = '0.00 ج.م';
            modalChargeInput.value = 0;
        }
    }

    function submitQuickOrder(e) {
        e.preventDefault();
        const qty = parseFloat(modalQuantity.value);
        const min = parseFloat(modalMin.textContent);
        const max = parseFloat(modalMax.textContent);

        if (qty < min || qty > max) {
            showToast(`الكمية يجب أن تكون بين ${min} و ${max}`, 'warning');
            return;
        }

        const formData = new FormData(e.target);

        btnSubmit.disabled = true;
        document.getElementById('loadingSpinner').classList.remove('hidden');

        fetch("{{ route('addOrder') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.api_response && data.api_response.order) {
                    showToast('تم الطلب بنجاح! رقم الطلب: ' + data.api_response.order, 'success');
                    closeOrderModal();
                    setTimeout(() => window.location.reload(), 2000);
                } else if (data.api_response && data.api_response.error) {
                    showToast('خطأ من المزود: ' + data.api_response.error, 'error');
                } else if (data.error) {
                    showToast(data.error, 'error');
                } else {
                    showToast(data.message || 'حدث خطأ غير متوقع', 'error');
                }
            })
            .catch(err => showToast('حدث خطأ أثناء الاتصال بالخادم', 'error'))
            .finally(() => {
                btnSubmit.disabled = false;
                document.getElementById('loadingSpinner').classList.add('hidden');
            });
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeOrderModal();
    });
</script>
@endpush
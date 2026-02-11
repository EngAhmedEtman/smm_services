@extends('layouts.app')

@section('title', 'كل الخدمات | Etman SMM')
@section('header_title', 'كل الخدمات')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Custom Search (Client Side Typeahead) -->
    <div class="mb-6 relative z-30">
        <label class="block text-sm font-medium text-gray-400 mb-2">بحث سريع عن خدمة</label>
        <div class="relative">
            <input type="text" id="serviceSearch" class="form-input block w-full rounded-lg h-12 px-4 bg-[#1e1e24] border-gray-700 text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="ابحث بالاسم أو الرقم...">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <!-- Dropdown Results -->
            <ul id="searchResults" class="hidden absolute z-50 w-full bg-[#1e1e24] border border-gray-700 rounded-b-lg shadow-xl max-h-60 overflow-y-auto mt-1 divide-y divide-gray-800"></ul>
        </div>
        <div id="searchStats" class="text-xs text-gray-400 mt-1 hidden"></div>
    </div>

    <!-- Services Table -->
    <div class="glass rounded-2xl overflow-hidden shadow-2xl border border-gray-800 mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right">
                <thead class="bg-gray-900/80 text-gray-400 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">الخدمة</th>
                        <th class="px-6 py-4">الفئة</th>
                        <th class="px-6 py-4">السعر / 1000</th>
                        <th class="px-6 py-4">الحدود (Min/Max)</th>
                        <th class="px-6 py-4 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($paginatedServices as $service)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 font-mono text-indigo-400 font-bold">#{{ $service['service'] }}</td>

                        <td class="px-6 py-4 max-w-md">
                            <p class="text-white font-medium mb-1">{{ $service['name'] }}</p>
                            <!-- Badge for Type (optional) -->
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
                            <button onclick="openOrderModal({{ json_encode($service) }})" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-lg hover:shadow-indigo-500/20 whitespace-nowrap">
                                طلب
                            </button>

                            <button onclick="toggleFavorite(this, {{ json_encode($service) }})" class="transition-all hover:scale-110 {{ in_array($service['service'], $favoriteIds) ? 'text-yellow-400' : 'text-gray-600 hover:text-yellow-400' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            لا توجد خدمات متاحة حالياً.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-6">
        {{ $paginatedServices->links('pagination::tailwind') }}
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
    // 1. Get All Services for Search (Passed from Controller)
    window.allServices = window.allServices || @json($services);

    // Elements
    const searchInput = document.getElementById('serviceSearch');
    const searchResults = document.getElementById('searchResults');
    const searchStats = document.getElementById('searchStats');

    // Handle Input
    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();

        if (term.length > 0) {
            const matches = allServices.filter(s =>
                s.name.toLowerCase().includes(term) ||
                s.service.toString().includes(term)
            );

            // Show matches
            searchResults.innerHTML = '';
            if (matches.length > 0) {
                matches.slice(0, 50).forEach(srv => { // Limit to 50 results for performance
                    const li = document.createElement('li');
                    li.className = 'p-3 hover:bg-white/5 cursor-pointer text-sm text-gray-300 transition-colors flex justify-between items-center group';
                    li.innerHTML = `
                        <div>
                            <span class="font-bold text-indigo-400 font-mono">#${srv.service}</span> 
                            <span class="mr-2 group-hover:text-white transition-colors">${srv.name}</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-800 px-2 py-0.5 rounded">${srv.category}</span>
                    `;

                    // On Click: Open Modal immediately
                    li.addEventListener('click', function() {
                        openOrderModal(srv);
                        searchResults.classList.add('hidden');
                        searchInput.value = ''; // Clear search
                        searchStats.classList.add('hidden');
                    });

                    searchResults.appendChild(li);
                });
                searchResults.classList.remove('hidden');
            } else {
                searchResults.innerHTML = '<li class="p-4 text-gray-500 text-sm text-center">لا توجد خدمات بهذه البيانات</li>';
                searchResults.classList.remove('hidden');
            }

            // Stats
            searchStats.textContent = `تم العثور على ${matches.length} نتيجة`;
            searchStats.classList.remove('hidden');

        } else {
            searchResults.classList.add('hidden');
            searchStats.classList.add('hidden');
        }
    });

    // Close on click outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
            searchStats.classList.add('hidden');
        }
    });
</script>

<script>
    // Toast Notification System (Using Global Alpine Component)
    function showToast(message, type = 'info') {
        window.dispatchEvent(new CustomEvent('notification', {
            detail: {
                id: Date.now(),
                type: type,
                title: type === 'error' ? 'خطأ' : (type === 'success' ? 'تم بنجاح' : 'تنبيه'),
                message: message
            }
        }));
    }

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
        modalServiceId.value = service.service;
        modalServiceRate.value = service.rate;
        modalMin.textContent = service.min;
        modalMax.textContent = service.max;

        // Reset form
        document.getElementById('quickOrderForm').reset();
        modalServiceId.value = service.service; // Reset clears hidden inputs too generally, so re-set
        modalTotal.textContent = '0.00 ج.م';
        modalChargeInput.value = 0;

        handleModalType(service.type);


        modal.classList.remove('hidden');
    }

    function closeOrderModal() {
        modal.classList.add('hidden');
    }

    // Calculate Price Live
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
        // Determine type from visibility or passed context? 
        // We stored type conceptually or we check which container is visible.
        const isCustom = !modalCommentsContainer.classList.contains('hidden');

        let qty = parseFloat(modalQuantity.value);
        if (isCustom) {
            const lines = modalComments.value.split(/\r\n|\r|\n/).filter(line => line.trim() !== '');
            qty = lines.length;
            modalQuantity.value = qty; // Update hidden quantity logic
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

    // Submit Form
    function submitQuickOrder(e) {
        e.preventDefault();

        // Basic Validation
        const qty = parseFloat(modalQuantity.value);
        const min = parseFloat(modalMin.textContent);
        const max = parseFloat(modalMax.textContent);

        if (qty < min || qty > max) {
            showToast(`الكمية يجب أن تكون بين ${min} و ${max}`, 'warning');
            return;
        }

        const formData = new FormData(e.target);
        const btnText = btnSubmit.querySelector('span');

        btnStartLoading();

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
                    showToast('تم استلام الطلب بنجاح! رقم الطلب: ' + data.api_response.order, 'success');
                    closeOrderModal();
                    // Optional: Reload to update balance if we had live component
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    handleErrors(data);
                }
            })
            .catch(err => {
                console.error(err);
                showToast('حدث خطأ غير متوقع', 'error');
            })
            .finally(() => {
                btnStopLoading();
            });
    }

    function handleErrors(data) {
        if (data.errors) {
            let msg = '';
            for (let key in data.errors) {
                showToast(data.errors[key][0], 'error'); // Show each error individually or just first
            }
        } else if (data.error) {
            showToast(data.error, 'error');
        } else if (data.message) {
            showToast(data.message, 'info');
        } else {
            showToast('حدث خطأ أثناء الطلب', 'error');
        }
    }

    function btnStartLoading() {
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
        document.getElementById('loadingSpinner').classList.remove('hidden');
    }

    function btnStopLoading() {
        btnSubmit.disabled = false;
        btnSubmit.classList.remove('opacity-75', 'cursor-not-allowed');
        document.getElementById('loadingSpinner').classList.add('hidden');
    }

    // Close on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeOrderModal();
        }
    });
</script>

<script>
    function toggleFavorite(btn, service) {
        // Toggle UI state immediately (Optimistic)
        const btnClasses = btn.querySelector('svg').parentElement.classList;
        let isAdding = false;

        if (btnClasses.contains('text-yellow-400')) {
            btnClasses.remove('text-yellow-400');
            btnClasses.add('text-gray-600');
        } else {
            isAdding = true;
            btnClasses.remove('text-gray-600');
            btnClasses.add('text-yellow-400');
        }

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
                if (isAdding) {
                    showToast('تم إضافة الخدمة للمفضلة بنجاح ⭐', 'success');
                } else {
                    showToast('تم إزالة الخدمة من المفضلة', 'info');
                }
            })
            .catch(err => {
                console.error(err);
                // Revert UI on error
                if (btnClasses.contains('text-yellow-400')) {
                    btnClasses.remove('text-yellow-400');
                    btnClasses.add('text-gray-600');
                } else {
                    btnClasses.remove('text-gray-600');
                    btnClasses.add('text-yellow-400');
                }
                showToast('حدث خطأ أثناء حفظ المفضلة', 'error');
            });
    }
</script>
@endpush
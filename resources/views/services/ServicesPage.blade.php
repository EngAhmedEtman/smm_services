@extends('layouts.app')

@section('title', 'طلب جديد | Etman SMM')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass rounded-2xl p-6 md:p-8 shadow-2xl">
        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            إنشاء طلب جديد
        </h1>

        <form action="{{ route('addOrder') }}" method="POST" id="orderForm" class="space-y-6">
            @csrf
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">بحث</label>
                <div class="relative">
                    <input type="text" id="serviceSearch" class="form-input block w-full rounded-lg h-12 px-4 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="ابحث عن الخدمة...">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <!-- Dropdown Results -->
                    <ul id="searchResults" class="hidden absolute z-50 w-full bg-gray-900 border border-gray-700 rounded-b-lg shadow-xl max-h-60 overflow-y-auto mt-1 divide-y divide-gray-800"></ul>
                </div>
                <div id="searchStats" class="text-xs text-gray-400 mt-1 hidden"></div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">الفئة</label>
                <div class="relative">
                    <select id="category" class="form-input block w-full rounded-lg h-12 px-4 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- اختر الفئة --</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">الخدمة</label>
                <div class="relative">
                    <select id="service" name="service" class="form-input block w-full rounded-lg h-12 px-4 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" disabled>
                        <option value="">-- اختر الخدمة --</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service Info Box (Hidden by default) -->
            <div id="serviceInfo" class="hidden bg-gray-800/50 rounded-lg p-4 border border-gray-700 text-sm space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-400">السعر لكل 1000:</span>
                    <span id="serviceRate" class="font-bold text-green-400">0.00 ج.م</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">الحد الأدنى:</span>
                    <span id="serviceMin" class="text-white">0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">الحد الأقصى:</span>
                    <span id="serviceMax" class="text-white">0</span>
                </div>
                <div class="pt-2 border-t border-gray-700">
                    <span class="text-gray-400 block mb-1">الوصف:</span>
                    <p id="serviceDesc" class="text-gray-300 text-xs leading-relaxed"></p>
                </div>
            </div>

            <!-- Link & Quantity Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="link" class="block text-sm font-medium text-gray-400 mb-2">الرابط</label>
                    <input type="url" id="link" name="link" class="form-input block w-full rounded-lg h-12 px-4 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="https://example.com/post">
                </div>

                <div id="quantityContainer" class="md:col-span-2">
                    <label for="quantity" class="block text-sm font-medium text-gray-400 mb-2">الكمية</label>
                    <input type="number" id="quantity" name="quantity" class="form-input block w-full rounded-lg h-12 px-4 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0">
                </div>

                <div id="commentsContainer" class="hidden md:col-span-2">
                    <label for="comments" class="block text-sm font-medium text-gray-400 mb-2">التعليقات (كل تعليق في سطر)</label>
                    <textarea id="comments" name="comments" rows="5" class="form-input block w-full rounded-lg px-4 py-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm placeholder-gray-600 bg-gray-900 border-gray-700 text-white" placeholder="اكتب تعليقاتك هنا...&#10;تعليق 1&#10;تعليق 2"></textarea>
                    <p class="text-xs text-gray-500 mt-1">إجمالي التعليقات: <span id="commentsCount" class="font-bold text-indigo-400">0</span></p>
                </div>
            </div>

            <!-- Charge (Read Only) -->
            <div class="bg-indigo-900/20 border border-indigo-500/30 rounded-xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-500/20 p-2 rounded-lg text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm text-gray-400">التكلفة الإجمالية</span>
                        <span class="text-xs text-indigo-300">يتم خصمها من رصيدك</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-white tracking-wider" id="totalCharge">0.00 ج.م</div>
                <input type="hidden" name="charge" id="chargeInput" value="0">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform transition hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                تأكيد الطلب
            </button>

        </form>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-gray-900 border border-green-500/30 rounded-2xl p-8 max-w-sm w-full mx-4 text-center shadow-2xl transform scale-100 transition-transform duration-300">
        <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white mb-2">تم الطلب بنجاح!</h2>
        <p class="text-gray-400 mb-6">رقم الطلب: <span id="modalOrderId" class="text-green-400 font-mono font-bold"></span></p>
        <p class="text-sm text-gray-500">سيتم تحديث الصفحة خلال لحظات...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Pass PHP data to JS
    const services = @json($services);

    // Elements
    const searchInput = document.getElementById('serviceSearch');
    const searchResults = document.getElementById('searchResults');
    const searchStats = document.getElementById('searchStats');
    const categorySelect = document.getElementById('category');
    const serviceSelect = document.getElementById('service');
    const quantityInput = document.getElementById('quantity');
    const commentsInput = document.getElementById('comments');
    const quantityContainer = document.getElementById('quantityContainer');
    const commentsContainer = document.getElementById('commentsContainer');
    const totalChargeDisplay = document.getElementById('totalCharge');
    const chargeInput = document.getElementById('chargeInput');
    const serviceInfo = document.getElementById('serviceInfo');
    const serviceRateEl = document.getElementById('serviceRate');
    const serviceMinEl = document.getElementById('serviceMin');
    const serviceMaxEl = document.getElementById('serviceMax');
    const serviceDescEl = document.getElementById('serviceDesc');

    // Modal Elements
    const successModal = document.getElementById('successModal');
    const modalOrderId = document.getElementById('modalOrderId');

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

    // 1. Populate Categories (Unique)
    const categories = [...new Set(services.map(s => s.category))];
    categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat;
        option.textContent = cat;
        categorySelect.appendChild(option);
    });

    // Helper to Populate Services
    function populateServicesOptions(list) {
        serviceSelect.innerHTML = '<option value="">-- اختر الخدمة --</option>';
        if (list.length > 0) {
            list.forEach(srv => {
                const option = document.createElement('option');
                option.value = srv.service;
                option.textContent = `${srv.service} - ${srv.name} [${Number(srv.rate).toFixed(2)} ج.م]`;
                option.dataset.rate = srv.rate;
                option.dataset.min = srv.min;
                option.dataset.max = srv.max;
                option.dataset.name = srv.name;
                option.dataset.type = srv.type;
                serviceSelect.appendChild(option);
            });
            serviceSelect.disabled = false;
        } else {
            serviceSelect.innerHTML = '<option value="">لا توجد خدمات مطابقة</option>';
            serviceSelect.disabled = true;
        }
    }

    // 2. Handle Category Change
    categorySelect.addEventListener('change', function() {
        const selectedCat = this.value;
        searchInput.value = ''; // Clear search when picking category

        // Reset Service
        serviceSelect.innerHTML = '<option value="">-- اختر الخدمة --</option>';
        serviceSelect.disabled = true; // Default to disabled until populated
        serviceInfo.classList.add('hidden');
        resetCalculation();

        if (selectedCat) {
            const filteredServices = services.filter(s => s.category === selectedCat);
            populateServicesOptions(filteredServices);
        }
    });

    // 2.5 Handle Search Input (Typeahead)
    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();

        if (term.length > 0) {
            const matches = services.filter(s =>
                s.name.toLowerCase().includes(term) ||
                s.service.toString().includes(term)
            );

            // Show matches in dropdown
            searchResults.innerHTML = '';
            if (matches.length > 0) {
                matches.forEach(srv => {
                    const li = document.createElement('li');
                    li.className = 'p-3 hover:bg-gray-800 cursor-pointer text-sm text-gray-300 transition-colors';
                    li.innerHTML = `
                        <span class="font-bold text-indigo-400">${srv.service}</span> - ${srv.name}
                    `;
                    // Handle clicking a suggestion
                    li.addEventListener('click', function() {
                        selectServiceFromSearch(srv);
                    });
                    searchResults.appendChild(li);
                });
                searchResults.classList.remove('hidden');
            } else {
                searchResults.innerHTML = '<li class="p-3 text-gray-500 text-sm text-center">لا توجد نتائج</li>';
                searchResults.classList.remove('hidden');
            }

            // Update stats
            searchStats.textContent = `تم العثور على ${matches.length} نتيجة`;
            searchStats.classList.remove('hidden');

        } else {
            searchResults.classList.add('hidden');
            searchStats.classList.add('hidden');
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Helper: Select Service from Search
    function selectServiceFromSearch(srv) {
        // 1. Set Category
        categorySelect.value = srv.category;

        // 2. Populate Services for this category
        const filteredServices = services.filter(s => s.category === srv.category);
        populateServicesOptions(filteredServices);

        // 3. Set Service ID
        serviceSelect.value = srv.service;

        // 4. Trigger Change Event to update details
        serviceSelect.dispatchEvent(new Event('change'));

        // 5. Cleanup UI
        searchResults.classList.add('hidden');
        searchInput.value = ''; // Optional: clear search or keep name
        searchStats.classList.add('hidden');
    }

    // 3. Handle Service Change
    serviceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            // Show Info
            serviceInfo.classList.remove('hidden');
            serviceRateEl.textContent = Number(selectedOption.dataset.rate).toFixed(4) + ' ج.م'; // Use more precision for small rates
            serviceMinEl.textContent = selectedOption.dataset.min;
            serviceMaxEl.textContent = selectedOption.dataset.max;
            serviceDescEl.textContent = selectedOption.dataset.name;

            // Handle Type Logic
            const type = selectedOption.dataset.type || 'Default';
            handleServiceType(type);

            calculatePrice();
        } else {
            serviceInfo.classList.add('hidden');
            resetCalculation();
        }
    });

    // 4. Handle Inputs Change
    quantityInput.addEventListener('input', calculatePrice);
    commentsInput.addEventListener('input', calculatePrice);

    function handleServiceType(type) {
        // Reset fields
        quantityContainer.classList.remove('hidden');
        commentsContainer.classList.add('hidden');
        quantityInput.readOnly = false;

        if (type === 'Custom Comments' || type === 'Custom Comments Package') {
            quantityContainer.classList.add('hidden');
            commentsContainer.classList.remove('hidden');
        } else if (type === 'Package') {
            // For Package, usually quantity is fixed (e.g. 1) or determined by service
            // We can hide quantity or make it readonly 1
            quantityInput.value = 1;
            quantityInput.readOnly = true;
            // quantityContainer.classList.add('hidden'); // Optional: hide it
        }
    }

    function calculatePrice() {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        let qty = parseFloat(quantityInput.value);
        const type = selectedOption.dataset.type || 'Default';

        if (type === 'Custom Comments' || type === 'Custom Comments Package') {
            const lines = commentsInput.value.split(/\r\n|\r|\n/).filter(line => line.trim() !== '');
            qty = lines.length;
            // Update quantity input for submission (hidden or visible)
            quantityInput.value = qty;
            const countEl = document.getElementById('commentsCount');
            if (countEl) countEl.textContent = qty;
        }

        if (selectedOption.value && qty > 0) {
            const rate = parseFloat(selectedOption.dataset.rate);
            const total = (qty / 1000) * rate;
            totalChargeDisplay.textContent = total.toFixed(4) + ' ج.م'; // 4 decimals standard for SMM
            chargeInput.value = total.toFixed(4); // Update hidden input
        } else {
            totalChargeDisplay.textContent = '0.00 ج.م';
            chargeInput.value = '0';
        }
    }

    function resetCalculation() {
        quantityInput.value = '';
        totalChargeDisplay.textContent = '0.00 ج.م';
        chargeInput.value = '0';
    }

    // 5. Handle Form Submit
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.textContent;

        // Log form data for debugging
        console.log('Form Data:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'جاري التنفيذ...';

        fetch("{{ route('addOrder') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server Response:', data);

                if (data.api_response && data.api_response.order) {
                    // Success Logic: Show Modal & Refresh
                    modalOrderId.textContent = data.api_response.order;
                    successModal.classList.remove('hidden');
                    showToast('تم إضافة الطلب بنجاح! ✓', 'success');

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000); // Wait 2 seconds then reload

                } else if (data.api_response && data.api_response.error) {
                    showToast('خطأ من المزود: ' + data.api_response.error, 'error');
                } else if (data.error) {
                    showToast('خطأ: ' + data.error, 'error');
                } else if (data.errors) {
                    // Show validation errors
                    for (const [key, messages] of Object.entries(data.errors)) {
                        showToast(messages[0], 'warning');
                    }
                } else if (data.message) {
                    showToast(data.message, 'info');
                } else {
                    showToast('حدث خطأ غير متوقع.', 'error');
                    console.error('Response:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('حدث خطأ أثناء الاتصال بالخادم.', 'error');
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            });
    });
</script>
@endpush
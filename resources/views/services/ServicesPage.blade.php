@extends('layouts.app')

@section('title', 'طلب جديد | Etman SMM')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-white mb-2">إنشاء طلب جديد</h1>
        <p class="text-gray-400 text-sm">اختر الخدمة المناسبة وعزز تواجدك الرقمي الآن</p>
    </div>

    <div class="fixed top-20 right-0 w-[500px] h-[500px] bg-pink-600/10 rounded-full blur-[120px] -z-10 pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <div class="bg-[#1e1e24]/80 backdrop-blur-md border border-gray-800/60 rounded-3xl p-6 md:p-8 shadow-2xl relative overflow-hidden group hover:border-pink-500/20 transition-all duration-500">

        <form action="{{ route('addOrder') }}" method="POST" id="orderForm" class="space-y-6 relative z-10">
            @csrf

            <!-- Quick Search -->
            <div class="relative group z-20">
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-focus-within:text-pink-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="serviceSearch"
                    class="block w-full rounded-xl bg-[#2b2b36]/50 border border-gray-700/50 text-white px-5 py-3.5 pr-12 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all placeholder-gray-500 shadow-inner"
                    placeholder="ابحث عن الخدمة...">

                <!-- Dropdown Results -->
                <ul id="searchResults" class="hidden absolute z-50 w-full bg-[#2b2b36] border border-gray-700 rounded-xl shadow-2xl max-h-60 overflow-y-auto mt-2 divide-y divide-gray-700/50 overflow-hidden ring-1 ring-black/50 scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-transparent"></ul>
                <div id="searchStats" class="text-[10px] text-gray-500 font-mono hidden px-1 mt-1 text-right"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Category Select -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-400 mr-1">القسم</label>
                    <div class="relative">
                        <select id="category" class="block w-full rounded-xl bg-[#0f0f13]/80 border border-gray-700/50 text-white px-4 py-3 appearance-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all cursor-pointer shadow-sm hover:border-gray-600">
                            <option value="">-- اختر القسم --</option>
                        </select>
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-500">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Service Select -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-400 mr-1">الخدمة</label>
                    <div class="relative">
                        <select id="service" name="service" class="block w-full rounded-xl bg-[#0f0f13]/80 border border-gray-700/50 text-white px-4 py-3 appearance-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:border-gray-600" disabled>
                            <option value="">-- اختر الخدمة --</option>
                        </select>
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-500">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details Box (Inline) -->
            <div id="serviceInfo" class="hidden bg-gradient-to-br from-[#2b2b36]/80 to-[#1e1e24]/80 border border-pink-500/20 rounded-xl p-5 space-y-4 transition-all duration-300 shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-1 bg-gradient-to-r from-pink-500/50 to-transparent opacity-50"></div>

                <div class="flex items-center justify-between border-b border-gray-700/50 pb-3">
                    <div class="text-sm text-gray-300 font-medium">سعر الـ 1000</div>
                    <div id="serviceRate" class="text-lg font-bold text-pink-400 font-mono">0.00 ج.م</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-[#1e1e24]/50 rounded-lg p-2.5 text-center border border-gray-700/30">
                        <span class="block text-[10px] text-gray-500 uppercase tracking-wider mb-1">الحد الأدنى</span>
                        <span id="serviceMin" class="font-mono text-white font-bold">0</span>
                    </div>
                    <div class="bg-[#1e1e24]/50 rounded-lg p-2.5 text-center border border-gray-700/30">
                        <span class="block text-[10px] text-gray-500 uppercase tracking-wider mb-1">الحد الأقصى</span>
                        <span id="serviceMax" class="font-mono text-white font-bold">0</span>
                    </div>
                </div>

                <div class="pt-1">
                    <div class="flex items-center gap-2 mb-2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-bold">الوصف وتفاصيل الخدمة</span>
                    </div>
                    <div class="bg-[#1e1e24]/50 rounded-lg p-3 border border-gray-700/30 max-h-32 overflow-y-auto custom-scrollbar scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-transparent">
                        <p id="serviceDesc" class="text-xs text-gray-300 leading-relaxed whitespace-pre-line"></p>
                    </div>
                </div>
            </div>

            <!-- Link Input -->
            <div class="space-y-1.5">
                <label for="link" class="text-xs font-semibold text-gray-400 mr-1">رابط الحساب / المنشور</label>
                <div class="relative group">
                    <input type="url" id="link" name="link"
                        class="block w-full rounded-xl bg-[#0f0f13]/80 border border-gray-700/50 text-white px-5 py-3.5 pl-12 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all placeholder-gray-600 shadow-sm"
                        placeholder="https://instagram.com/...">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-focus-within:text-pink-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quantity -->
            <div id="quantityContainer" class="space-y-1.5">
                <label for="quantity" class="text-xs font-semibold text-gray-400 mr-1">الكمية المطلوبة</label>
                <div class="relative group">
                    <input type="number" id="quantity" name="quantity"
                        class="block w-full rounded-xl bg-[#0f0f13]/80 border border-gray-700/50 text-white px-5 py-3.5 pl-12 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all placeholder-gray-600 shadow-sm"
                        placeholder="0">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-focus-within:text-pink-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Comments Box -->
            <div id="commentsContainer" class="hidden space-y-1.5">
                <label for="comments" class="text-xs font-semibold text-gray-400 mr-1">التعليقات (كل تعليق في سطر)</label>
                <div class="relative">
                    <textarea id="comments" name="comments" rows="5"
                        class="block w-full rounded-xl bg-[#0f0f13]/80 border border-gray-700/50 text-white px-5 py-3.5 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all placeholder-gray-600 resize-none shadow-sm"
                        placeholder="اكتب تعليقاتك هنا...&#10;تعليق 1&#10;تعليق 2"></textarea>
                    <div class="absolute bottom-3 left-4 text-xs">
                        <span class="text-gray-500">العدد:</span> <span id="commentsCount" class="font-bold text-pink-400">0</span>
                    </div>
                </div>
            </div>

            <!-- Total Charge Bar -->
            <div class="bg-[#2b2b36]/80 backdrop-blur rounded-xl p-5 border border-gray-700/50 flex items-center justify-between shadow-lg relative overflow-hidden">
                <div class="absolute left-0 inset-y-0 w-1 bg-gradient-to-b from-pink-500 to-rose-600"></div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-pink-500/10 flex items-center justify-center text-pink-400 border border-pink-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-white">إجمالي التكلفة</span>
                        <span class="text-[10px] text-gray-500">يخصم من الرصيد</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="block text-2xl font-black text-white font-mono tracking-tight" id="totalCharge">0.00</span>
                    <span class="text-xs text-gray-400 font-bold ml-1">ج.م</span>
                </div>
                <input type="hidden" name="charge" id="chargeInput" value="0">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-500 hover:to-rose-500 text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-pink-900/30 transform transition-all hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-4 focus:ring-pink-500/20 disabled:opacity-70 disabled:cursor-not-allowed border border-white/10">
                تأكيد وإرسال الطلب
            </button>

        </form>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-md transition-all duration-300 opacity-0">
    <div class="bg-[#1e1e24] border border-gray-700 rounded-3xl p-8 max-w-sm w-full mx-4 text-center shadow-2xl transform scale-95 transition-all duration-300 relative overflow-hidden">
        <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6 ring-1 ring-green-500/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-xl font-bold text-white mb-2">تم استلام الطلب!</h2>
        <p class="text-gray-400 mb-6 text-sm">رقم العملية: <span id="modalOrderId" class="text-green-400 font-mono font-bold"></span></p>

        <div class="flex items-center justify-center gap-2 text-xs text-gray-500">
            جاري التحديث...
            <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
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

        // Info Box Elements
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
            window.dispatchEvent(new CustomEvent('notification', {
                detail: {
                    id: Date.now(),
                    type: type,
                    title: type === 'error' ? 'خطأ' : (type === 'success' ? 'تم بنجاح' : 'تنبيه'),
                    message: message
                }
            }));
        }

        // --- Logic ---

        // 1. Populate Categories
        const categories = [...new Set(services.map(s => s.category))];
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            categorySelect.appendChild(option);
        });

        // Helper: Populate Services
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
            searchInput.value = '';

            // Reset Service
            serviceSelect.innerHTML = '<option value="">-- اختر الخدمة --</option>';
            serviceSelect.disabled = true;

            // Hide Info Box
            serviceInfo.classList.add('hidden');

            resetCalculation();

            if (selectedCat) {
                const filteredServices = services.filter(s => s.category === selectedCat);
                populateServicesOptions(filteredServices);
            }
        });

        // 3. Handle Typeahead Search
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();

            if (term.length > 0) {
                const matches = services.filter(s =>
                    s.name.toLowerCase().includes(term) ||
                    s.service.toString().includes(term)
                );

                searchResults.innerHTML = '';
                if (matches.length > 0) {
                    matches.forEach(srv => {
                        const li = document.createElement('li');
                        li.className = 'p-3 hover:bg-[#1e1e24] cursor-pointer text-sm text-gray-300 transition-colors border-b border-gray-700/50 last:border-0 flex items-center justify-between group';
                        li.innerHTML = `
                            <div class="flex flex-col">
                                <span class="font-bold text-white group-hover:text-indigo-400 transition-colors">${srv.service}</span>
                                <span class="text-xs text-gray-500 truncate max-w-[200px]">${srv.name}</span>
                            </div>
                            <span class="text-xs font-mono text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">${Number(srv.rate).toFixed(2)}</span>
                        `;
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

                searchStats.textContent = `نتائج: ${matches.length}`;
                searchStats.classList.remove('hidden');

            } else {
                searchResults.classList.add('hidden');
                searchStats.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        function selectServiceFromSearch(srv) {
            categorySelect.value = srv.category;
            const filteredServices = services.filter(s => s.category === srv.category);
            populateServicesOptions(filteredServices);
            serviceSelect.value = srv.service;
            serviceSelect.dispatchEvent(new Event('change'));
            searchResults.classList.add('hidden');
            searchInput.value = '';
            searchStats.classList.add('hidden');
        }

        // 4. Handle Service Selection
        serviceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value) {
                // Show Info
                serviceInfo.classList.remove('hidden');

                serviceRateEl.textContent = Number(selectedOption.dataset.rate).toFixed(4) + ' ج.م';
                serviceMinEl.textContent = selectedOption.dataset.min;
                serviceMaxEl.textContent = selectedOption.dataset.max;
                serviceDescEl.textContent = selectedOption.dataset.name;

                const type = selectedOption.dataset.type || 'Default';
                handleServiceType(type);
                calculatePrice();
            } else {
                serviceInfo.classList.add('hidden');
                resetCalculation();
            }
        });

        // 5. Inputs & Calculation
        quantityInput.addEventListener('input', calculatePrice);
        commentsInput.addEventListener('input', calculatePrice);

        function handleServiceType(type) {
            quantityContainer.classList.remove('hidden');
            commentsContainer.classList.add('hidden');
            quantityInput.readOnly = false;

            if (type === 'Custom Comments' || type === 'Custom Comments Package') {
                quantityContainer.classList.add('hidden');
                commentsContainer.classList.remove('hidden');
            } else if (type === 'Package') {
                quantityInput.value = 1;
                quantityInput.readOnly = true;
            }
        }

        function calculatePrice() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            let qty = parseFloat(quantityInput.value);
            const type = selectedOption.dataset.type || 'Default';

            if (type === 'Custom Comments' || type === 'Custom Comments Package') {
                const lines = commentsInput.value.split(/\r\n|\r|\n/).filter(line => line.trim() !== '');
                qty = lines.length;
                quantityInput.value = qty;
                const countEl = document.getElementById('commentsCount');
                if (countEl) countEl.textContent = qty;
            }

            if (selectedOption.value && qty > 0) {
                const rate = parseFloat(selectedOption.dataset.rate);
                const total = (qty / 1000) * rate;
                totalChargeDisplay.textContent = total.toFixed(4);
                chargeInput.value = total.toFixed(4);
            } else {
                totalChargeDisplay.textContent = '0.00';
                chargeInput.value = '0';
            }
        }

        function resetCalculation() {
            quantityInput.value = '';
            totalChargeDisplay.textContent = '0.00';
            chargeInput.value = '0';
        }

        // 6. Form Submission
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnContent = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> جاري التنفيذ...</span>';

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
                    if (data.api_response && data.api_response.order) {
                        modalOrderId.textContent = data.api_response.order;
                        successModal.classList.remove('hidden');
                        void successModal.offsetWidth;
                        successModal.classList.remove('opacity-0');

                        showToast('تم إضافة الطلب بنجاح! ✓', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);

                    } else if (data.api_response && data.api_response.error) {
                        showToast('خطأ من المزود: ' + data.api_response.error, 'error');
                    } else if (data.error) {
                        showToast('خطأ: ' + data.error, 'error');
                    } else if (data.errors) {
                        for (const [key, messages] of Object.entries(data.errors)) {
                            showToast(messages[0], 'warning');
                        }
                    } else if (data.message) {
                        showToast(data.message, 'info');
                    } else {
                        showToast('حدث خطأ غير متوقع.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('حدث خطأ أثناء الاتصال بالخادم.', 'error');
                })
                .finally(() => {
                    if (!successModal.classList.contains('hidden')) return;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                });
        });
    });
</script>
@endpush
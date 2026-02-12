@extends('layouts.app')

@section('title', 'المفضلة | Etman SMM')
@section('header_title', 'الخدمات المفضلة')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-pink-600/20 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <!-- Favorites List Container -->
    <div class="flex flex-col gap-4">
        @forelse($favoriteServices as $service)
        <div class="bg-[#1a1a20]/80 backdrop-blur-sm border border-gray-800/60 rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 relative hover:bg-[#202026]/90 hover:border-pink-500/30 transition-all duration-300 group shadow-lg hover:shadow-pink-500/5">

            <!-- Right Side: Info -->
            <div class="flex-1 w-full text-right">
                <div class="flex items-center gap-2 mb-2 flex-wrap justify-end md:justify-start">
                    <!-- ID -->
                    <span class="text-pink-500 font-mono text-sm font-bold bg-pink-500/10 px-2 py-0.5 rounded">{{ $service['service'] }}</span>

                    <!-- Name -->
                    <h3 class="text-white font-bold text-sm leading-snug ml-2 group-hover:text-pink-200 transition-colors">
                        {{ $service['name'] }}
                    </h3>

                    <!-- Category Badge -->
                    <span class="bg-gray-800/80 text-gray-400 text-[10px] px-2 py-0.5 rounded border border-gray-700/50">
                        {{ $service['category'] }}
                    </span>

                    <!-- Favorite Star (Remove) -->
                    <button onclick="removeFavorite(this, {{ $service['service'] }})" class="text-pink-500 hover:text-pink-400 hover:scale-110 transition-all bg-pink-500/10 p-1.5 rounded-full hover:bg-pink-500/20" title="إزالة من المفضلة">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </button>
                </div>

                <!-- Details Line -->
                <div class="flex items-center gap-4 text-xs text-slate-400 font-medium justify-end md:justify-start">
                    <div class="bg-[#25252e]/50 px-2 py-1 rounded border border-gray-700/30">
                        الحد الأدنى: <span class="text-white font-mono">{{ $service['min'] }}</span>
                    </div>
                    <div class="bg-[#25252e]/50 px-2 py-1 rounded border border-gray-700/30">
                        أقصى: <span class="text-white font-mono">{{ $service['max'] }}</span>
                    </div>
                    <div class="bg-[#25252e]/50 px-2 py-1 rounded border border-gray-700/30">
                        النوع: <span class="text-gray-300">{{ $service['type'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Left Side: Buttons -->
            <div class="flex flex-col gap-2 w-full md:w-auto min-w-[140px]">
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
                <button class="w-full bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-500 hover:to-rose-500 text-white font-bold py-2 px-4 rounded-lg shadow-lg shadow-pink-900/40 flex justify-center items-center gap-1 text-sm transition-all transform active:scale-95 border border-white/10" onclick="openOrderModal({{ json_encode($serviceObj) }})">
                    <span>EGP {{ number_format($service['rate'], 4) }}</span>
                </button>
                <button class="w-full bg-[#25252e] hover:bg-[#2f2f3a] text-gray-400 hover:text-white font-medium py-2 px-4 rounded-lg border border-gray-700/50 text-sm transition-colors cursor-default">
                    طلب الخدمة
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-[#1e1e24]/50 backdrop-blur rounded-2xl border border-gray-800/50">
            <div class="inline-flex bg-gray-800/50 p-4 rounded-full mb-4 border border-gray-700/50">
                <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-white font-bold text-lg">قائمة المفضلة فارغة</h3>
            <p class="text-gray-500 text-sm mt-2">يمكنك إضافة خدمات للمفضلة من صفحة "كل الخدمات"</p>
            <a href="{{ route('services.index') }}" class="inline-flex mt-6 bg-gray-800 hover:bg-gray-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors border border-gray-700">تصفح الخدمات</a>
        </div>
        @endforelse
    </div>

</div>

<!-- Order Modal (Unchanged) -->
<div id="orderModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-md transition-all duration-300 opacity-0 px-4">
    <div class="bg-[#1e1e24] border border-gray-700 rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl relative transform scale-95 transition-all duration-300">
        <button onclick="closeOrderModal()" class="absolute top-5 right-5 text-gray-400 hover:text-white transition-colors bg-gray-800/50 p-2 rounded-full hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-xl font-bold text-white mb-1">طلب جديد</h2>
        <div class="flex items-center gap-2 mb-6">
            <span class="text-[#FF0055] bg-[#FF0055]/10 px-2 py-0.5 rounded text-xs font-mono font-bold" id="modalServiceIdDisplay">#0</span>
            <p id="modalServiceName" class="text-gray-400 text-sm truncate max-w-[250px]"></p>
        </div>

        <form id="quickOrderForm" class="space-y-5" onsubmit="submitQuickOrder(event)">
            @csrf
            <input type="hidden" name="service" id="modalServiceId">
            <input type="hidden" id="modalServiceRate">
            <input type="hidden" name="charge" id="modalChargeInput">

            <!-- Link -->
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">الرابط</label>
                <input type="url" name="link" required
                    class="block w-full rounded-xl bg-[#0f0f13] border border-gray-700 text-white px-4 py-3.5 focus:ring-1 focus:ring-[#FF0055] focus:border-[#FF0055] transition-all placeholder-gray-600 text-sm"
                    placeholder="https://...">
            </div>

            <!-- Quantity -->
            <div id="modalQuantityContainer" class="space-y-1.5">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">الكمية</label>
                <input type="number" name="quantity" id="modalQuantity" required
                    class="block w-full rounded-xl bg-[#0f0f13] border border-gray-700 text-white px-4 py-3.5 focus:ring-1 focus:ring-[#FF0055] focus:border-[#FF0055] transition-all placeholder-gray-600 text-sm"
                    placeholder="0">
                <div class="flex justify-between px-1 text-[10px] text-gray-500 font-mono">
                    <span>Min: <span id="modalMin" class="text-gray-300">0</span></span>
                    <span>Max: <span id="modalMax" class="text-gray-300">0</span></span>
                </div>
            </div>

            <!-- Comments -->
            <div id="modalCommentsContainer" class="hidden space-y-1.5">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">التعليقات</label>
                <textarea name="comments" id="modalComments" rows="4"
                    class="block w-full rounded-xl bg-[#0f0f13] border border-gray-700 text-white px-4 py-3.5 focus:ring-1 focus:ring-[#FF0055] focus:border-[#FF0055] transition-all placeholder-gray-600 text-sm resize-none"
                    placeholder="كل تعليق في سطر..."></textarea>
                <p class="text-[10px] text-[#FF0055] text-left px-1">العدد: <span id="modalCommentsCount">0</span></p>
            </div>

            <div class="bg-[#2b2b36] rounded-xl p-4 border border-gray-700/50 flex justify-between items-center shadow-lg">
                <span class="text-xs text-gray-400 font-medium">الإجمالي</span>
                <span id="modalTotalPrice" class="text-xl font-bold text-white font-mono tracking-tight">0.00 <span class="text-xs text-gray-500">ج.م</span></span>
            </div>

            <button type="submit" id="btnSubmit" class="w-full bg-[#FF0055] hover:bg-[#d6004b] text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-[#FF0055]/20 flex justify-center gap-2 items-center text-sm disabled:opacity-70 disabled:cursor-not-allowed">
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
    function showToast(message, type = 'info') {
        window.dispatchEvent(new CustomEvent('notification', {
            detail: {
                id: Date.now(),
                type: type,
                title: 'تنبيه',
                message: message
            }
        }));
    }

    // Modal Logic
    const modal = document.getElementById('orderModal');
    const modalContent = modal.querySelector('div.bg-\\[\\#1e1e24\\]');
    const modalServiceName = document.getElementById('modalServiceName');
    const modalServiceIdDisplay = document.getElementById('modalServiceIdDisplay');
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

    function openOrderModal(service) {
        modalServiceName.textContent = service.name;
        modalServiceIdDisplay.textContent = '#' + service.service;
        modalServiceId.value = service.service;
        modalServiceRate.value = service.rate;
        modalMin.textContent = service.min;
        modalMax.textContent = service.max;

        document.getElementById('quickOrderForm').reset();
        modalTotal.innerHTML = '0.00 <span class="text-xs text-gray-500">ج.م</span>';
        modalChargeInput.value = 0;

        handleModalType(service.type);

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function closeOrderModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    modalQuantity.addEventListener('input', calculateModalPrice);
    modalComments.addEventListener('input', calculateModalPrice);

    function handleModalType(type) {
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
            modalTotal.innerHTML = total.toFixed(4) + ' <span class="text-xs text-gray-500">ج.م</span>';
            modalChargeInput.value = total.toFixed(4);
        } else {
            modalTotal.innerHTML = '0.00 <span class="text-xs text-gray-500">ج.م</span>';
            modalChargeInput.value = 0;
        }
    }

    function submitQuickOrder(e) {
        e.preventDefault();
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
                    showToast('تم الطلب بنجاح', 'success');
                    closeOrderModal();
                } else {
                    handleErrors(data);
                }
            })
            .catch(err => showToast('خطأ غير متوقع', 'error'))
            .finally(() => {
                btnSubmit.disabled = false;
                document.getElementById('loadingSpinner').classList.add('hidden');
            });
    }

    function handleErrors(data) {
        if (data.errors)
            for (let key in data.errors) showToast(data.errors[key][0], 'error');
        else if (data.error) showToast(data.error, 'error');
        else if (data.message) showToast(data.message, 'info');
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeOrderModal();
    });

    function removeFavorite(btn, serviceId) {
        const row = btn.closest('.group');
        row.style.opacity = '0.5';

        fetch("{{ route('services.makeFavorite') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    service_id: serviceId,
                    // Sending only ID for removal logic in backend might be enough if controller handles it, 
                    // but keeping full structure generally safe if reusing same endpoint
                })
            })
            .then(res => res.json())
            .then(data => {
                row.remove();
                if (document.querySelector('.group') === null) {
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
</script>
@endpush
@extends('layouts.app')

@section('title', 'ربط واتساب | Etman SMM')

@section('content')
<div class="flex justify-center items-center min-h-[calc(100vh-140px)] direction-rtl">

    <!-- Background Animated Blobs -->
    <div class="fixed top-1/4 left-1/4 w-96 h-96 bg-green-500/10 rounded-full blur-[100px] -z-10 animate-pulse"></div>
    <div class="fixed bottom-1/4 right-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px] -z-10 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="bg-[#1e1e24]/60 backdrop-blur-xl p-8 md:p-12 rounded-3xl w-full max-w-lg text-center relative overflow-hidden group border border-white/10 shadow-2xl">

        <!-- Decoration Background -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-green-500/10 rounded-full group-hover:bg-green-500/20 transition-all duration-1000 blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-teal-500/10 rounded-full group-hover:bg-teal-500/20 transition-all duration-1000 blur-3xl"></div>

        <div class="relative z-10 flex flex-col items-center">

            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-500/30 transform group-hover:rotate-6 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 17h.01M16 14.207l1.293-1.293a1 1 0 00-1.414-1.414l-1.293 1.293a1 1 0 001.414 1.414zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h2 class="text-3xl font-bold text-white mb-2">ربط حساب واتساب</h2>
            <p class="text-gray-400 text-sm mb-8 leading-relaxed">افتح تطبيق واتساب على هاتفك، اذهب إلى <b>الأجهزة المرتبطة</b>، وامسح الكود أدناه.</p>

            <div class="bg-white/5 p-2 rounded-2xl md:rounded-3xl shadow-2xl shadow-green-500/10 mb-8 relative group-hover:scale-105 transition-transform duration-500">
                <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden p-2">
                    <img src="{{ $qr }}" alt="QR Code" class="w-64 h-64 object-contain">
                </div>
                <!-- Scan Overlay Animation -->
                <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-2xl">
                    <div class="h-1 bg-green-500/50 absolute top-0 left-0 right-0 shadow-[0_0_20px_rgba(34,197,94,0.5)] animate-[scan_3s_linear_infinite]"></div>
                </div>
            </div>

            <div class="w-full space-y-4">
                <div class="flex justify-between items-center text-sm text-gray-300 bg-[#16161a]/80 p-4 rounded-xl border border-gray-700/50">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        صلاحية الكود
                    </span>
                    <div class="font-mono bg-white/5 px-3 py-1 rounded text-green-400 font-bold tracking-wider">
                        <span id="timer">{{ $expires_in }}</span> <span class="text-xs text-gray-500">ثانية</span>
                    </div>
                </div>

                <div class="bg-[#16161a]/40 rounded-xl p-4 text-right text-xs text-gray-400 space-y-2 border border-white/5">
                    <p class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> 1. افتح واتساب في هاتفك</p>
                    <p class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> 2. اضغط على القائمة (⋮) أو الإعدادات</p>
                    <p class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> 3. اختر "الأجهزة المرتبطة"</p>
                    <p class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> 4. اضغط على "ربط جهاز" وامسح الكود</p>
                </div>

                <!-- Phone Number Input -->
                <div class="mt-4">
                    <label class="block text-gray-400 text-sm mb-2 text-right">رقم الهاتف المرتبط <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <button id="saveNumberBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors">
                            حفظ
                        </button>
                        <input type="text" id="phoneNumberInput" placeholder="201xxxxxxxxx" class="flex-1 bg-[#16161a] border border-gray-700 rounded-xl px-4 py-2 text-white text-center focus:outline-none focus:border-green-500 transition-colors">
                    </div>
                    <p id="saveStatus" class="text-xs mt-1 text-right h-4"></p>
                </div>

                <button onclick="window.location.reload()" class="w-full mt-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white py-4 rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/40 flex items-center justify-center gap-2 group-hover:translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin-slow" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    تحديث الكود
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0% {
            top: 0%;
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            top: 100%;
            opacity: 0;
        }
    }

    .animate-spin-slow {
        animation: spin 3s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    // Countdown Timer logic
    let timeLeft = parseInt("{{ $expires_in }}");
    const timerElement = document.getElementById('timer');

    const countdown = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerElement.textContent = "منتهي";
            timerElement.classList.replace('text-green-400', 'text-red-500');
            // Reload page to get new QR
            setTimeout(() => window.location.reload(), 2000);
        }
    }, 1000);

    // Auto-Redirect on Connection Success
    const instanceId = "{{ $instance_id }}";
    const checkStatus = setInterval(() => {
        fetch(`{{ route('whatsapp.debug', ':id') }}`.replace(':id', instanceId))
            .then(response => response.json())
            .then(data => {
                // Check for success status or similar message
                if (data.status === 'success' || (data.message && data.message.includes('connected'))) {
                    // Stop checking and redirect
                    clearInterval(checkStatus);
                    window.location.href = "{{ route('whatsapp.accounts') }}";
                }
            })
            .catch(error => console.error('Error checking status:', error));
    }, 5000); // Check every 5 seconds

    // Save Number Logic
    document.getElementById('saveNumberBtn').addEventListener('click', function() {
        const phone = document.getElementById('phoneNumberInput').value;
        const statusEl = document.getElementById('saveStatus');

        if (!phone) {
            statusEl.textContent = 'يرجى كتابة الرقم أولاً';
            statusEl.className = 'text-xs mt-1 text-right h-4 text-red-500';
            return;
        }

        statusEl.textContent = 'جاري الحفظ...';
        statusEl.className = 'text-xs mt-1 text-right h-4 text-gray-400';

        fetch("{{ route('whatsapp.updateNumber') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    instance_id: instanceId,
                    phone_number: phone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    statusEl.textContent = 'تم حفظ الرقم بنجاح ✅';
                    statusEl.className = 'text-xs mt-1 text-right h-4 text-green-500';
                } else {
                    statusEl.textContent = 'حدث خطأ أثناء الحفظ';
                    statusEl.className = 'text-xs mt-1 text-right h-4 text-red-500';
                }
            })
            .catch(err => {
                console.error(err);
                statusEl.textContent = 'خطأ في الاتصال';
                statusEl.className = 'text-xs mt-1 text-right h-4 text-red-500';
            });
    });
</script>
@endsection
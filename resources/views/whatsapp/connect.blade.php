@extends('layouts.app')

@section('title', 'ربط واتساب | Etman SMM')

@section('content')
<div class="flex justify-center items-center min-h-[calc(100vh-200px)]">
    <div class="glass p-8 rounded-2xl w-full max-w-md text-center relative overflow-hidden group">
        <!-- Decoration Background -->
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-green-500/10 rounded-full group-hover:bg-green-500/20 transition-all duration-500 blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full group-hover:bg-indigo-500/20 transition-all duration-500 blur-2xl"></div>

        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-white mb-2">ربط حساب واتساب</h2>
            <p class="text-gray-400 text-sm mb-6">قم بمسح الغمز (QR Code) أدناه لربط حسابك</p>

            <div class="bg-white p-4 rounded-xl inline-block mb-6 shadow-lg shadow-green-500/10">
                <img src="{{ $qr }}" alt="QR Code" class="w-64 h-64 object-contain">
            </div>

            <div class="space-y-4">
                <div class="text-sm text-gray-300 bg-white/5 p-3 rounded-lg border border-white/10">
                    <p class="mb-1">صلاحية الكود:</p>
                    <span id="timer" class="text-xl font-bold text-green-400 font-mono">{{ $expires_in }}</span> <span class="text-xs text-gray-500">ثانية</span>
                </div>

                <div class="text-xs text-gray-500 space-y-1 text-right px-4">
                    <p>1. افتح واتساب في هاتفك</p>
                    <p>2. اضغط على القائمة (⋮) أو الإعدادات</p>
                    <p>3. اختر "الأجهزة المرتبطة"</p>
                    <p>4. اضغط على "ربط جهاز" وامسح الكود</p>
                </div>

                <button onclick="window.location.reload()" class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    تحديث الكود
                </button>
            </div>
        </div>
    </div>
</div>

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
</script>
@endsection
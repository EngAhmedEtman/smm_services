@extends('layouts.app')

@section('title', 'مراقبة الحملة | Etman SMM')

@section('header_title', 'غرفة العمليات: ' . $campaign->campaign_name)

@section('content')
<div class="space-y-8 direction-rtl" x-data="campaignMonitor({{ $campaign->id }}, '{{ $campaign->status }}')">

    <!-- Header Actions & Status -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#1e1e24]/60 backdrop-blur-md p-6 rounded-2xl border border-gray-800 relative overflow-hidden">
        <!-- Background Grid Animation -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px] -z-10"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-2xl font-bold text-white tracking-wide">لوحة التحكم المباشرة</h2>
                <div class="px-3 py-1 rounded-full text-xs font-mono border flex items-center gap-2"
                    :class="{
                        'bg-yellow-500/10 text-yellow-500 border-yellow-500/20': status === 'pending',
                        'bg-blue-500/10 text-blue-500 border-blue-500/20 animate-pulse': status === 'sending',
                        'bg-orange-500/10 text-orange-500 border-orange-500/20': status === 'paused',
                        'bg-green-500/10 text-green-500 border-green-500/20': status === 'completed',
                        'bg-red-500/10 text-red-500 border-red-500/20': status === 'failed'
                    }">
                    <span class="w-2 h-2 rounded-full"
                        :class="{
                            'bg-yellow-500': status === 'pending',
                            'bg-blue-500 animate-ping': status === 'sending',
                            'bg-orange-500': status === 'paused',
                            'bg-green-500': status === 'completed',
                            'bg-red-500': status === 'failed'
                        }"></span>
                    <span x-text="statusText">جاري الاتصال...</span>
                </div>
            </div>
            <p class="text-gray-400 text-sm font-mono">CAMPAIGN ID: <span class="text-indigo-400">#{{ $campaign->id }}</span> | INSTANCE: <span class="text-indigo-400" dir="ltr">{{ $campaign->whatsappInstance ? $campaign->whatsappInstance->phone_number : $campaign->instance_id }}</span></p>
        </div>

        <div class="flex gap-3 relative z-10">
            <!-- Start Button -->
            <button @click="updateStatus('sending')" x-show="status === 'pending' || status === 'paused'"
                class="bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-green-900/30 flex items-center gap-2 hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                </svg>
                <span x-text="status === 'paused' ? 'استئناف الحملة' : 'بدء الحملة'"></span>
            </button>

            <!-- Pause Button -->
            <button @click="updateStatus('paused')" x-show="status === 'sending'"
                class="bg-yellow-600 hover:bg-yellow-500 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-yellow-900/30 flex items-center gap-2 hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                إيقاف مؤقت
            </button>

            <a href="{{ route('whatsapp.campaigns.index') }}" class="px-4 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-700 text-gray-300 hover:text-white transition-all">
                عودة
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden">
            <div class="text-gray-500 text-xs font-mono uppercase tracking-wider mb-2">Total Targets</div>
            <div class="text-4xl font-black text-white" x-text="total">0</div>
            <div class="w-full h-1 bg-gray-800 mt-4 rounded-full overflow-hidden">
                <div class="h-full bg-white/20 w-full"></div>
            </div>
        </div>

        <!-- Sent -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-green-500/10 rounded-full blur-xl group-hover:bg-green-500/20 transition-all"></div>
            <div class="text-green-500 text-xs font-mono uppercase tracking-wider mb-2">Successfully Sent</div>
            <div class="text-4xl font-black text-green-400" x-text="sent">0</div>
            <!-- Mini Progress -->
            <div class="w-full h-1 bg-gray-800 mt-4 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 transition-all duration-500" :style="'width: ' + (total > 0 ? (sent/total)*100 : 0) + '%'"></div>
            </div>
        </div>

        <!-- Failed -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-red-500/10 rounded-full blur-xl group-hover:bg-red-500/20 transition-all"></div>
            <div class="text-red-500 text-xs font-mono uppercase tracking-wider mb-2">Failed / Errors</div>
            <div class="text-4xl font-black text-red-400" x-text="failed">0</div>
            <!-- Mini Progress -->
            <div class="w-full h-1 bg-gray-800 mt-4 rounded-full overflow-hidden">
                <div class="h-full bg-red-500 transition-all duration-500" :style="'width: ' + (total > 0 ? (failed/total)*100 : 0) + '%'"></div>
            </div>
        </div>

        <!-- Remaining -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden">
            <div class="text-blue-500 text-xs font-mono uppercase tracking-wider mb-2">Pending Queue</div>
            <div class="text-4xl font-black text-blue-400" x-text="total - (sent + failed)">0</div>
            <div class="w-full h-1 bg-gray-800 mt-4 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500/50 transition-all duration-500" :style="'width: ' + (total > 0 ? ((total - (sent + failed))/total)*100 : 0) + '%'"></div>
            </div>
        </div>
    </div>

    <!-- Main Progress & Visualization -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Progress Circular -->
        <div class="lg:col-span-1 bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-8 rounded-2xl flex flex-col items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-indigo-900/10 pointer-events-none"></div>

            <!-- Circular Progress -->
            <div class="relative w-48 h-48">
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    <circle class="text-gray-800 stroke-current" stroke-width="8" cx="50" cy="50" r="40" fill="transparent"></circle>
                    <circle class="text-indigo-500 progress-ring__circle stroke-current transition-all duration-700 ease-out"
                        stroke-width="8"
                        stroke-linecap="round"
                        cx="50" cy="50" r="40"
                        fill="transparent"
                        :stroke-dasharray="251.2"
                        :stroke-dashoffset="251.2 - (251.2 * percent) / 100"></circle>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center flex-col">
                    <span class="text-4xl font-black text-white" x-text="percent + '%'">0%</span>
                    <span class="text-xs text-indigo-400 font-mono mt-1">COMPLETED</span>
                </div>
            </div>

            <div class="mt-8 text-center space-y-2">
                <p class="text-gray-400 text-xs font-mono">ESTIMATED COMPLETION</p>
                <p class="text-white font-bold" x-text="status === 'completed' ? 'تم الانتهاء' : (status === 'sending' ? 'جاري الحساب...' : '--:--')"></p>
            </div>
        </div>

        @if(auth()->user()->role === 'super_admin')
        <!-- Terminal Logs -->
        <div class="lg:col-span-2 bg-[#0d1117] border border-gray-800 rounded-2xl overflow-hidden flex flex-col h-[400px] shadow-2xl relative">
            <!-- Terminal Header -->
            <div class="bg-[#161b22] px-4 py-3 border-b border-gray-800 flex items-center justify-between">
                <div class="flex gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                </div>
                <div class="text-xs font-mono text-gray-500">user@etman-smm:~/campaigns/logs</div>
            </div>

            <!-- Scrollable Area -->
            <div class="flex-1 overflow-y-auto p-4 font-mono text-sm space-y-2 custom-scrollbar" id="logs-container">
                <template x-for="log in logs" :key="log.updated_at + log.phone_number">
                    <div class="flex items-start gap-3 animate-fade-in group hover:bg-white/5 p-1 rounded -mx-1">
                        <span class="text-gray-600 pointer-events-none select-none">➜</span>
                        <div class="flex-1">
                            <span class="text-blue-500 text-xs" x-text="'[' + new Date(log.updated_at).toLocaleTimeString('en-US', {hour12: false}) + ']'"></span>

                            <span class="ml-2 font-bold"
                                :class="log.status === 'sent' ? 'text-green-400' : 'text-red-400'"
                                x-text="log.status === 'sent' ? 'SUCCESS' : 'FAILED'"></span>

                            <span class="text-gray-300 ml-2">Target: <span class="text-yellow-100" x-text="log.phone_number"></span></span>

                            <span x-show="log.error_message" class="block text-red-400/80 text-xs mt-1 pl-4 border-l-2 border-red-500/30" x-text="'> Error: ' + log.error_message"></span>
                        </div>
                    </div>
                </template>

                <div x-show="logs.length === 0" class="text-center text-gray-700 py-12">
                    <div class="mb-2 text-4xl opacity-20">⌨</div>
                    <div>Waiting for logs...</div>
                </div>

                <!-- Typing Indictor (Fake) -->
                <div x-show="status === 'sending'" class="animate-pulse text-gray-600 mt-2">
                    <span class="inline-block w-2 H-4 bg-gray-600 align-middle">_</span>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    function campaignMonitor(campaignId, initialStatus) {
        return {
            status: initialStatus,
            total: 0,
            sent: 0,
            failed: 0,
            percent: 0,
            logs: [],
            pollInterval: null,

            get statusText() {
                const map = {
                    'pending': 'في الانتظار',
                    'sending': 'جاري الإرسال...',
                    'paused': 'متوقف مؤقتاً',
                    'completed': 'مكتمل',
                    'failed': 'فشل'
                };
                return map[this.status] || this.status;
            },

            init() {
                this.poll();
                this.pollInterval = setInterval(() => {
                    this.poll();
                }, 3000); // Poll every 3 seconds
            },

            async poll() {
                try {
                    const response = await fetch(`{{ url('/whatsapp/campaigns') }}/${campaignId}/progress`);
                    const data = await response.json();

                    this.status = data.status;
                    this.total = data.total_numbers;
                    this.sent = data.sent_count;
                    this.failed = data.failed_count;

                    // Logs
                    this.logs = data.recent_logs;

                    // Calculate Percent
                    if (this.total > 0) {
                        this.percent = Math.round(((this.sent + this.failed) / this.total) * 100);
                    } else {
                        this.percent = 0;
                    }

                } catch (error) {
                    console.error('Polling error:', error);
                }
            },

            async updateStatus(newStatus) {
                try {
                    const response = await fetch('{{ route("whatsapp.campaigns.status", $campaign->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.status = newStatus;
                        this.poll(); // Update immediately
                    }
                } catch (error) {
                    alert('Error updating status');
                }
            }
        };
    }
</script>

<style>
    /* Gradient Noise Background helper */
    .bg-noise {
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
    }

    .progress-ring__circle {
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>
@endpush
@endsection
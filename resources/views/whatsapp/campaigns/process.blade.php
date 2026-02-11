@extends('layouts.app')

@section('title', 'متابعة الحملة | Etman SMM')

@section('header_title', 'متابعة الحملة: ' . $campaign->campaign_name)

@section('content')
<div class="space-y-6" x-data="campaignMonitor({{ $campaign->id }}, '{{ $campaign->status }}')">

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-800 text-center">
            <div class="text-gray-400 text-sm mb-1">الإجمالي</div>
            <div class="text-3xl font-bold text-white" x-text="total">0</div>
        </div>
        <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-800 text-center">
            <div class="text-gray-400 text-sm mb-1">تم الإرسال</div>
            <div class="text-3xl font-bold text-green-500" x-text="sent">0</div>
        </div>
        <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-800 text-center">
            <div class="text-gray-400 text-sm mb-1">فشل</div>
            <div class="text-3xl font-bold text-red-500" x-text="failed">0</div>
        </div>
        <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-800 text-center">
            <div class="text-gray-400 text-sm mb-1">المتبقي</div>
            <div class="text-3xl font-bold text-blue-500" x-text="total - (sent + failed)">0</div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-800">
        <div class="flex justify-between text-sm mb-2">
            <span class="text-gray-400">التقدم الكلي</span>
            <span class="text-indigo-400 font-mono" x-text="percent + '%'">0%</span>
        </div>
        <div class="w-full h-4 bg-gray-800 rounded-full overflow-hidden">
            <div class="h-full bg-indigo-500 transition-all duration-500 striped-bar" :style="'width: ' + percent + '%'"></div>
        </div>
        <div class="mt-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs font-bold border"
                :class="{
                    'bg-yellow-500/10 text-yellow-500 border-yellow-500/20': status === 'pending',
                    'bg-blue-500/10 text-blue-500 border-blue-500/20 animate-pulse': status === 'processing',
                    'bg-orange-500/10 text-orange-500 border-orange-500/20': status === 'paused',
                    'bg-green-500/10 text-green-500 border-green-500/20': status === 'completed'
                }"
                x-text="statusText">
                جاري التحميل...
            </span>
        </div>
    </div>

    <!-- Live Logs -->
    <div class="bg-gray-900/50 rounded-xl border border-gray-800 overflow-hidden flex flex-col h-96">
        <div class="p-4 border-b border-gray-800 bg-gray-800/50 flex justify-between items-center">
            <h3 class="font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                سجل العمليات المباشر
            </h3>
            <div class="flex gap-2">
                <!-- Start Button -->
                <button @click="updateStatus('processing')" x-show="status === 'pending' || status === 'paused'"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-sm font-bold transition-all">
                    بدء / استئناف
                </button>

                <!-- Pause Button -->
                <button @click="updateStatus('paused')" x-show="status === 'processing'"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg text-sm font-bold transition-all">
                    إيقاف مؤقت
                </button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-2 font-mono text-sm" id="logs-container">
            <template x-for="log in logs" :key="log.updated_at + log.phone_number">
                <div class="flex items-center gap-3 p-2 rounded hover:bg-white/5 transition-colors border-l-2"
                    :class="{
                        'border-green-500 bg-green-500/5': log.status === 'sent',
                        'border-red-500 bg-red-500/5': log.status !== 'sent'
                    }">
                    <span class="text-gray-500 text-xs" x-text="new Date(log.updated_at).toLocaleTimeString('en-US', {hour12: false})"></span>
                    <span :class="log.status === 'sent' ? 'text-green-400' : 'text-red-400'" class="font-bold w-16" x-text="log.status === 'sent' ? 'SENT' : 'FAIL'"></span>
                    <span class="text-gray-300" x-text="log.phone_number"></span>
                    <span x-show="log.error_message" class="text-red-400 text-xs ml-auto" x-text="log.error_message"></span>
                </div>
            </template>
            <div x-show="logs.length === 0" class="text-center text-gray-600 py-10">
                لا توجد عمليات حديثة...
            </div>
        </div>
    </div>
</div>

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
                    'processing': 'جاري العمل...',
                    'paused': 'متوقف مؤقتاً',
                    'completed': 'مكتمل'
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
    .striped-bar {
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-size: 1rem 1rem;
        animation: progress-stripes 1s linear infinite;
    }

    @keyframes progress-stripes {
        0% {
            background-position: 1rem 0;
        }

        100% {
            background-position: 0 0;
        }
    }
</style>
@endsection
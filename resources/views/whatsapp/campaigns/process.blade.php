@extends('layouts.app')

@section('title', 'معالجة الحملة | ' . $campaign->campaign_name)

@section('header_title', 'معالجة الحملة: ' . $campaign->campaign_name)

@section('content')
<div class="space-y-6" x-data="campaignProcessor({{ $campaign->id }}, {{ $campaign->min_delay }}, {{ $campaign->max_delay }})">

    <!-- Status Header -->
    <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-800 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-white mb-1">{{ $campaign->campaign_name }}</h2>
            <div class="flex items-center gap-4 text-sm text-gray-400">
                <span>المجموعة: {{ $campaign->contact->contact_name ?? 'غير معروف' }}</span>
                <span>•</span>
                <span>الرقم المرسل: {{ $campaign->instance_id }}</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <template x-if="status === 'running'">
                <button @click="pauseCampaign()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2.5 rounded-lg font-bold transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    إيقاف مؤقت
                </button>
            </template>

            <template x-if="status === 'paused' || status === 'idle'">
                <button @click="startCampaign()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-bold transition-all flex items-center gap-2 shadow-lg shadow-indigo-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="status === 'idle' ? 'بدء الإرسال' : 'استئناف الإرسال'"></span>
                </button>
            </template>

            <div class="bg-gray-800 px-4 py-2 rounded-lg text-white font-mono" x-text="timer > 0 ? 'انتظار: ' + timer + 's' : 'جاهز'"></div>
        </div>
    </div>

    <!-- Progress -->
    <div class="glass p-6 rounded-2xl border border-gray-800">
        <div class="flex justify-between text-sm mb-2">
            <span class="text-gray-400">التقدم الكلي</span>
            <span class="text-white font-bold"><span x-text="sentCount"></span> / <span x-text="totalCount"></span></span>
        </div>
        <div class="w-full h-4 bg-gray-800 rounded-full overflow-hidden">
            <div class="h-full bg-indigo-500 transition-all duration-500" :style="'width: ' + progressPercentage + '%'"></div>
        </div>
        <div class="flex justify-between mt-4 text-center">
            <div>
                <span class="block text-2xl font-bold text-green-400" x-text="sentCount"></span>
                <span class="text-xs text-gray-500">تم الإرسال</span>
            </div>
            <div>
                <span class="block text-2xl font-bold text-red-400" x-text="failedCount"></span>
                <span class="text-xs text-gray-500">فشل</span>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-400" x-text="pendingCount"></span>
                <span class="text-xs text-gray-500">متبقي</span>
            </div>
        </div>
    </div>

    <!-- Logs Console -->
    <div class="glass rounded-2xl border border-gray-800 overflow-hidden flex flex-col h-96">
        <div class="bg-gray-900/80 px-4 py-3 border-b border-gray-700 flex justify-between">
            <h3 class="font-bold text-white text-sm">سجل العمليات المباشر</h3>
            <span class="text-xs text-gray-500" x-show="logs.length > 0">عرض آخر 50 عملية</span>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-2 font-mono text-sm" id="log-container">
            <template x-for="log in logs" :key="log.id">
                <div class="flex items-center gap-2 p-2 rounded transition-colors" :class="{
                    'bg-green-500/10 text-green-400': log.status === 'success',
                    'bg-red-500/10 text-red-400': log.status === 'error',
                    'bg-blue-500/10 text-blue-400': log.status === 'processing'
                }">
                    <span class="text-xs opacity-50" x-text="log.time"></span>
                    <span x-text="log.message"></span>
                </div>
            </template>
            <div x-show="logs.length === 0" class="text-center text-gray-500 py-10">
                في انتظار بدء العملية...
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('campaignProcessor', (campaignId, minDelay, maxDelay) => ({
            status: 'idle', // idle, running, paused, completed
            timer: 0,
            totalCount: {
                {
                    $campaign - > total_numbers
                }
            },
            sentCount: {
                {
                    $campaign - > sent_count
                }
            },
            failedCount: {
                {
                    $campaign - > failed_count
                }
            },
            pendingCount: {
                {
                    $campaign - > total_numbers - ($campaign - > sent_count + $campaign - > failed_count)
                }
            },
            logs: [],

            // List of pending Log IDs to process
            // We will fetch this via AJAX on start or pass it from controller
            // Passing huge list in blade is bad. Better to fetch "next batch" via AJAX.
            // For simplicity: We will call "process-next" endpoint which returns the next result.

            get progressPercentage() {
                if (this.totalCount === 0) return 0;
                return Math.round(((this.sentCount + this.failedCount) / this.totalCount) * 100);
            },

            init() {
                // Initialize status based on server status
                const serverStatus = '{{ $campaign->status }}';
                if (serverStatus === 'processing') {
                    this.status = 'running';
                    this.addLog('info', 'استكمال الحملة تلقائياً...');
                    this.processNext();
                } else if (serverStatus === 'paused') {
                    this.status = 'paused';
                    this.addLog('info', 'الحملة متوقفة مؤقتاً.');
                } else if (serverStatus === 'completed') {
                    this.status = 'completed';
                    this.addLog('success', 'الحملة مكتملة.');
                } else {
                    this.status = 'idle';
                    this.addLog('info', 'الجهاز جاهز. اضغط بدء الإرسال للانطلاق.');
                }
            },

            async startCampaign() {
                this.status = 'running';
                this.addLog('info', 'تم بدء الحملة...');

                // Sync with server
                await fetch('{{ route("whatsapp.campaigns.status", $campaign->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: 'processing'
                    })
                });

                this.processNext();
            },

            async pauseCampaign() {
                this.status = 'paused';
                this.addLog('info', 'تم الإيقاف المؤقت.');

                // Sync with server
                await fetch('{{ route("whatsapp.campaigns.status", $campaign->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: 'paused'
                    })
                });
            },

            async processNext() {
                if (this.status !== 'running') return;

                if (this.pendingCount <= 0) {
                    this.status = 'completed';
                    this.addLog('success', 'تم انتهاء الحملة بنجاح!');
                    return;
                }

                try {
                    this.addLog('processing', 'جاري إرسال رسالة...');

                    const response = await fetch(`{{ url('/whatsapp/campaigns') }}/${campaignId}/send-single`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        this.sentCount++;
                        this.addLog('success', `تم الإرسال بنجاح للرقم: ${data.phone}`);
                    } else if (data.status === 'completed') {
                        // Server says no more pending
                        this.status = 'completed';
                        this.addLog('success', 'تم انتهاء الحملة بجميع الأرقام.');
                        return;
                    } else {
                        this.failedCount++;
                        this.addLog('error', `فشل الإرسال للرقم ${data.phone ?? 'Unknown'}: ${data.message}`);
                    }

                    this.pendingCount--;

                    // Random Delay
                    const delay = Math.floor(Math.random() * (maxDelay - minDelay + 1) + minDelay);
                    this.timer = delay;

                    const countdown = setInterval(() => {
                        if (this.status !== 'running') {
                            clearInterval(countdown);
                            return;
                        }
                        this.timer--;
                        if (this.timer <= 0) {
                            clearInterval(countdown);
                            this.processNext();
                        }
                    }, 1000);

                } catch (error) {
                    this.addLog('error', 'خطأ في الاتصال بالنظام. سيتم إعادة المحاولة بعد 5 ثواني.');
                    setTimeout(() => this.processNext(), 5000);
                }
            },

            addLog(type, message) {
                this.logs.unshift({
                    id: Date.now(),
                    time: new Date().toLocaleTimeString(),
                    status: type,
                    message: message
                });
                if (this.logs.length > 50) this.logs.pop();
            }
        }));
    });
</script>
@endsection
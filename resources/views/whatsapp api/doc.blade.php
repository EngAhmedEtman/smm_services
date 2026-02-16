@extends('layouts.app')

@section('title', 'API Reference | EtViral')

@section('header_title', 'Developer API Reference')

@section('content')
@php
$baseUrl = 'https://EtViral.com';

// Define Endpoints Data (Restored Arabic Content)
$instanceEndpoints = [
    [
        'id' => 'test-middleware',
        'method' => 'GET',
        'url' => '/api/v1/test',
        'title' => 'Test Middleware',
        'desc' => 'اختبار الاتصال والتحقق من صلاحية الـ Token.',
        'params' => [],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "message": "API connection successful" }'
    ],
    [
        'id' => 'create-instance',
        'method' => 'GET',
        'url' => '/api/v1/create_instance',
        'title' => 'Create Instance',
        'desc' => 'إنشاء Instance ID جديد لربط جهاز واتساب.',
        'params' => [],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "instance_id": "6092...", "message": "Instance created successfully" }'
    ],
    [
        'id' => 'get-qrcode',
        'method' => 'GET',
        'url' => '/api/v1/get_qrcode',
        'title' => 'Get QR Code',
        'desc' => 'الحصول على كود QR لربط الجهاز.',
        'params' => [
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة (Instance ID)']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "base64": "data:image/png;base64,...", "message": "QR code generated" }'
    ],
    [
        'id' => 'set-webhook',
        'method' => 'GET',
        'url' => '/api/v1/set_webhook',
        'title' => 'Set Webhook',
        'desc' => 'ضبط رابط الـ Webhook لاستقبال الرسائل.',
        'params' => [
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة'],
            ['name' => 'enable', 'type' => 'int', 'required' => true, 'desc' => '1 للتفعيل، 0 للإيقاف'],
            ['name' => 'webhook_url', 'type' => 'string', 'required' => false, 'desc' => 'رابط الـ Webhook']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "message": "Webhook updated successfully" }'
    ],
    [
        'id' => 'reboot',
        'method' => 'GET',
        'url' => '/api/v1/reboot',
        'title' => 'Reboot Instance',
        'desc' => 'إعادة تشغيل الجلسة لتحديث الاتصال.',
        'params' => [
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "message": "Reboot request sent" }'
    ],
    [
        'id' => 'reset',
        'method' => 'GET',
        'url' => '/api/v1/reset_instance',
        'title' => 'Reset Instance',
        'desc' => 'حذف الجلسة الحالية وإنشاء ID جديد (تسجيل خروج).',
        'params' => [
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "message": "Instance reset successfully" }'
    ],
    [
        'id' => 'reconnect',
        'method' => 'GET',
        'url' => '/api/reconnect',
        'title' => 'Reconnect',
        'desc' => 'محاولة إعادة الاتصال في حالة انقطاعه.',
        'params' => [
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true]
        ],
        'example_response' => '{ "status": "success", "message": "Reconnection attempt started" }'
    ]
];

$messagingEndpoints = [
    [
        'id' => 'send-text',
        'method' => 'POST',
        'url' => '/api/v1/send_text',
        'title' => 'Send Text',
        'desc' => 'إرسال رسالة نصية لرقم واتساب.',
        'params' => [
            ['name' => 'number', 'type' => 'string', 'required' => true, 'desc' => 'رقم الهاتف (دولي) مثل 2010xxxx'],
            ['name' => 'message', 'type' => 'string', 'required' => true, 'desc' => 'نص الرسالة'],
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'desc' => 'text (افتراضي)']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true],
            ['name' => 'Content-Type', 'value' => 'application/json', 'required' => true]
        ],
        'body' => '{
  "number": "2010xxxxxxxx",
  "message": "Hello from EtViral!",
  "instance_id": "YOUR_INSTANCE_ID",
  "type": "text"
}',
        'example_response' => '{ "status": "success", "message": "Message sent successfully", "data": { "id": "..." } }'
    ],
    [
        'id' => 'send-media',
        'method' => 'POST',
        'url' => '/api/v1/send_media',
        'title' => 'Send Media',
        'desc' => 'إرسال وسائط (صور، فيديو، ملفات).',
        'params' => [
            ['name' => 'number', 'type' => 'string', 'required' => true, 'desc' => 'رقم الهاتف'],
            ['name' => 'media_url', 'type' => 'string', 'required' => true, 'desc' => 'رابط مباشر للملف (Public URL)'],
            ['name' => 'message', 'type' => 'string', 'required' => false, 'desc' => 'وصف للملف (Caption)'],
            ['name' => 'instance_id', 'type' => 'string', 'required' => true, 'desc' => 'معرف الجلسة'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'desc' => 'media']
        ],
        'headers' => [
            ['name' => 'key', 'value' => 'YOUR_API_KEY', 'required' => true],
            ['name' => 'Content-Type', 'value' => 'application/json', 'required' => true]
        ],
        'body' => '{
  "number": "2010xxxxxxxx",
  "media_url": "https://example.com/image.png",
  "message": "Check this out!",
  "instance_id": "YOUR_INSTANCE_ID",
  "type": "media"
}',
        'example_response' => '{ "status": "success", "message": "Media sent successfully" }'
    ]
];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Hero Section -->
    <div id="intro" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 p-12 shadow-2xl">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 mb-6 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-sm font-medium">متاح الآن</span>
            </div>

            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                EtViral WhatsApp API
            </h1>
            <p class="text-xl text-indigo-100/90 mb-8 max-w-3xl leading-relaxed">
                وثائق وأدوات المطورين لدمج خدمات واتساب. أرسل الرسائل، أدر الجلسات، واستقبل التحديثات الفورية بكل سهولة.
            </p>

            <!-- Base URL -->
            <div class="inline-flex items-center gap-4 px-6 py-4 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs text-indigo-200/70 mb-1">Base URL</span>
                        <code class="text-white font-mono text-lg">{{ $baseUrl }}</code>
                    </div>
                </div>
                <button onclick="navigator.clipboard.writeText('{{ $baseUrl }}')" 
                    class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Authentication Section -->
    <div id="authentication" class="bg-gradient-to-br from-gray-900/90 to-gray-800/90 backdrop-blur-xl rounded-2xl border border-white/10 p-8 md:p-10">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-indigo-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-white">المصادقة</h2>
                <p class="text-gray-400">Authentication</p>
            </div>
        </div>

        <p class="text-gray-300 text-lg leading-relaxed mb-8">
            جميع الطلبات تتطلب وجود مفتاح API صالح في الـ Header. يمكنك الحصول على مفتاحك من 
            <a href="{{ route('whatsapp.connect') }}" class="text-indigo-400 hover:text-indigo-300 underline underline-offset-2">لوحة التحكم</a>.
        </p>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Required Header -->
            <div class="bg-[#0a0a0f] rounded-xl border border-white/10 p-6">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Required Header</h4>
                <div class="flex items-center justify-between p-4 bg-gray-900/50 rounded-lg border border-white/5">
                    <code class="text-yellow-400 font-mono">key</code>
                    <code class="text-gray-500 font-mono text-sm">YOUR_API_KEY</code>
                </div>
            </div>

            <!-- Security Warning -->
            <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/20 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-200 mb-1">تحذير أمني</h4>
                        <p class="text-sm text-amber-200/80 leading-relaxed">
                            لا تشارك المفتاح في كود العميل (Client-side). استخدمه من السيرفر فقط.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Endpoints -->
    @foreach(array_merge($instanceEndpoints, $messagingEndpoints) as $endpoint)
    @php
        $methodColors = [
            'GET' => ['text' => 'text-emerald-400', 'bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/30'],
            'POST' => ['text' => 'text-blue-400', 'bg' => 'bg-blue-500/10', 'border' => 'border-blue-500/30'],
        ];
        $colors = $methodColors[$endpoint['method']] ?? ['text' => 'text-gray-400', 'bg' => 'bg-gray-500/10', 'border' => 'border-gray-500/30'];
    @endphp

    <div id="{{ $endpoint['id'] }}" class="bg-gradient-to-br from-gray-900/90 to-gray-800/90 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden">
        <div class="p-8 md:p-10 space-y-8">
            
            <!-- Header -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold {{ $colors['text'] }} {{ $colors['bg'] }} border {{ $colors['border'] }}">
                        {{ $endpoint['method'] }}
                    </span>
                    <h3 class="text-3xl font-bold text-white">{{ $endpoint['title'] }}</h3>
                </div>

                <div class="flex items-center gap-3 p-4 bg-[#0a0a0f] border border-white/10 rounded-xl">
                    <code class="flex-1 font-mono text-indigo-300 break-all">{{ $baseUrl }}{{ $endpoint['url'] }}</code>
                    <button onclick="navigator.clipboard.writeText('{{ $baseUrl }}{{ $endpoint['url'] }}')" 
                        class="p-2 hover:bg-white/10 rounded-lg transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>

                <p class="text-gray-300 text-lg leading-relaxed">{{ $endpoint['desc'] }}</p>
            </div>

            <!-- Content Grid -->
            <div class="grid lg:grid-cols-2 gap-8">
                
                <!-- Left: Parameters & Headers -->
                <div class="space-y-6">
                    
                    <!-- Headers -->
                    @if(!empty($endpoint['headers']))
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Headers
                        </h4>
                        <div class="space-y-3">
                            @foreach($endpoint['headers'] as $header)
                            <div class="flex items-center justify-between p-4 bg-[#0a0a0f] rounded-xl border border-white/5">
                                <div class="flex items-center gap-3">
                                    <code class="text-yellow-400 font-mono font-bold">{{ $header['name'] }}</code>
                                    @if($header['required'])
                                    <span class="px-2 py-0.5 bg-rose-500/20 text-rose-400 text-xs rounded-md font-bold border border-rose-500/30">Required</span>
                                    @endif
                                </div>
                                <code class="text-gray-500 font-mono text-sm">{{ $header['value'] }}</code>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Parameters -->
                    @if(!empty($endpoint['params']))
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Parameters
                        </h4>
                        <div class="space-y-3">
                            @foreach($endpoint['params'] as $param)
                            <div class="p-4 bg-[#0a0a0f] rounded-xl border border-white/5 hover:border-white/10 transition-colors">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <code class="text-indigo-400 font-mono font-bold">{{ $param['name'] }}</code>
                                        <span class="px-2 py-0.5 bg-gray-800 text-gray-400 text-xs rounded uppercase font-mono">{{ $param['type'] }}</span>
                                    </div>
                                    @if($param['required'])
                                    <span class="px-2 py-0.5 bg-rose-500/20 text-rose-400 text-xs rounded-md font-bold border border-rose-500/30">Required</span>
                                    @else
                                    <span class="px-2 py-0.5 bg-gray-700/50 text-gray-400 text-xs rounded-md">Optional</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-400 leading-relaxed">{{ $param['desc'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Body (for POST requests) -->
                    @if(isset($endpoint['body']))
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                            </svg>
                            Request Body
                        </h4>
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl opacity-20 blur"></div>
                            <div class="relative bg-[#0a0a0f] rounded-xl border border-white/10 overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-3 bg-[#13151a] border-b border-white/10">
                                    <span class="text-xs font-mono text-gray-500">JSON</span>
                                    <button onclick="navigator.clipboard.writeText(`{{ addslashes($endpoint['body']) }}`)" 
                                        class="p-1.5 hover:bg-white/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-gray-400 hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-5 overflow-x-auto custom-scrollbar">
                                    <pre class="font-mono text-sm text-gray-300 leading-relaxed">{{ $endpoint['body'] }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right: Example Request & Response -->
                <div class="space-y-6">
                    
                    <!-- Example Request -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Example Request
                        </h4>
                        <div class="relative group">
                            <div class="absolute -inset-0.5 {{ $colors['bg'] }} rounded-xl opacity-20 blur"></div>
                            <div class="relative bg-[#0a0a0f] rounded-xl border border-white/10 overflow-hidden">
                                <!-- Code Header -->
                                <div class="flex items-center justify-between px-4 py-3 bg-[#13151a] border-b border-white/10">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $colors['text'] }} {{ $colors['bg'] }} border {{ $colors['border'] }}">
                                            {{ $endpoint['method'] }}
                                        </span>
                                        <span class="text-xs font-mono text-gray-500">{{ $endpoint['url'] }}</span>
                                    </div>
                                    <button class="p-1.5 hover:bg-white/10 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4 text-gray-400 hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Code Content -->
                                <div class="p-5 overflow-x-auto custom-scrollbar">
                                    <div class="font-mono text-sm space-y-3">
                                        <!-- Method & URL -->
                                        <div class="flex items-center gap-2">
                                            <span class="{{ $colors['text'] }} font-bold">{{ $endpoint['method'] }}</span>
                                            <span class="text-green-400">{{ $baseUrl }}{{ $endpoint['url'] }}</span>
                                        </div>

                                        <!-- Headers -->
                                        @if(!empty($endpoint['headers']))
                                        <div class="space-y-1 pt-2">
                                            @foreach($endpoint['headers'] as $header)
                                            <div class="text-gray-400">
                                                <span class="text-yellow-400">{{ $header['name'] }}:</span>
                                                <span class="text-gray-300"> {{ $header['value'] }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif

                                        <!-- Body -->
                                        @if(isset($endpoint['body']))
                                        <div class="pt-2">
                                            <div class="text-purple-400 mb-1">Body:</div>
                                            <pre class="text-gray-300 pl-4 border-l-2 border-gray-700">{{ $endpoint['body'] }}</pre>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Response -->
                    @if(isset($endpoint['example_response']))
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Response
                        </h4>
                        <div class="bg-[#0a0a0f] rounded-xl border border-white/10 overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-3 bg-emerald-500/5 border-b border-emerald-500/20">
                                <span class="text-xs font-mono text-emerald-400 flex items-center gap-2">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                    200 OK
                                </span>
                            </div>
                            <div class="p-5 overflow-x-auto custom-scrollbar">
                                <pre class="font-mono text-sm text-emerald-300/90 leading-relaxed">{{ $endpoint['example_response'] }}</pre>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
    @endforeach

    <!-- Footer -->
    <div class="text-center py-8">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} EtViral API Documentation. جميع الحقوق محفوظة.
        </p>
    </div>

</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #1a1c23;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    html {
        scroll-behavior: smooth;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .7;
        }
    }
</style>
@endsection
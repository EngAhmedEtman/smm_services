@extends('layouts.app')

@section('title', 'حملات واتساب | Etman SMM')
@section('header_title', 'حملات واتساب')

@section('content')
<div class="space-y-6 direction-rtl">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white mb-1">إدارة الحملات</h2>
            <p class="text-gray-400 text-sm">تتبع وإدارة جميع حملات الواتساب الخاصة بك من مكان واحد.</p>
        </div>
        <a href="{{ route('whatsapp.campaigns.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>حملة جديدة</span>
        </a>
    </div>

    <!-- Quick Stats (Simplified) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-700/50 flex flex-col justify-between h-full">
            <div class="text-gray-400 text-xs font-medium mb-2">إجمالي الحملات</div>
            <div class="text-2xl font-bold text-white">{{ $campaigns->total() }}</div>
        </div>
        <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-700/50 flex flex-col justify-between h-full">
            <div class="text-gray-400 text-xs font-medium mb-2">حملات نشطة</div>
            <div class="text-2xl font-bold text-green-400">{{ $campaigns->where('status', 'sending')->count() }}</div>
        </div>
        <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-700/50 flex flex-col justify-between h-full">
            <div class="text-gray-400 text-xs font-medium mb-2">قيد الانتظار</div>
            <div class="text-2xl font-bold text-yellow-400">{{ $campaigns->where('status', 'pending')->count() }}</div>
        </div>
        <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-700/50 flex flex-col justify-between h-full">
            <div class="text-gray-400 text-xs font-medium mb-2">مكتملة / أخرى</div>
            <div class="text-2xl font-bold text-blue-400">{{ $campaigns->whereIn('status', ['completed', 'failed', 'paused'])->count() }}</div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg flex items-center gap-2 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Data Table -->
    <div class="bg-[#1e1e24] border border-gray-800 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-gray-900/50 border-b border-gray-800 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">اسم الحملة</th>
                        <th class="px-6 py-4 font-medium">الحالة</th>
                        <th class="px-6 py-4 font-medium">التقدم</th>
                        <th class="px-6 py-4 font-medium">التاريخ</th>
                        <th class="px-6 py-4 font-medium text-left">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($campaigns as $campaign)
                    @php
                    $progress = $campaign->total_numbers > 0 ? round((($campaign->sent_count + $campaign->failed_count) / $campaign->total_numbers) * 100) : 0;
                    $statusColors = [
                    'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                    'sending' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                    'paused' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                    'completed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                    'failed' => 'bg-red-500/10 text-red-500 border-red-500/20',
                    ];
                    $statusLabels = [
                    'pending' => 'انتظار',
                    'sending' => 'جاري الإرسال',
                    'paused' => 'مؤقت',
                    'completed' => 'مكتمل',
                    'failed' => 'فشل',
                    ];
                    @endphp
                    <tr class="hover:bg-gray-800/30 transition-colors group">
                        <!-- Campaign Name & Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-500 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-white text-sm mb-1">{{ $campaign->campaign_name }}</div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <span class="font-mono text-indigo-400">{{ $campaign->whatsappInstance ? $campaign->whatsappInstance->phone_number : $campaign->instance_id }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $campaign->contact->contact_name ?? 'مجموعة محذوفة' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-md text-xs font-medium border {{ $statusColors[$campaign->status] ?? 'bg-gray-800 text-gray-400 border-gray-700' }}">
                                {{ $statusLabels[$campaign->status] ?? $campaign->status }}
                            </span>
                        </td>

                        <!-- Progress -->
                        <td class="px-6 py-4 min-w-[200px]">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="text-white font-medium">{{ $progress }}%</span>
                                <span class="text-gray-500">{{ $campaign->sent_count }}/{{ $campaign->total_numbers }}</span>
                            </div>
                            <div class="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            {{ $campaign->created_at->format('Y/m/d h:i A') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('whatsapp.campaigns.process', $campaign->id) }}" class="p-1.5 rounded-md hover:bg-gray-700 text-gray-400 hover:text-white transition-colors" title="مراقبة">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                @if(in_array($campaign->status, ['pending', 'paused']))
                                <form action="{{ route('whatsapp.campaigns.status', $campaign->id) }}" method="POST" class="inline-block">
                                    @csrf <input type="hidden" name="status" value="sending">
                                    <button class="p-1.5 rounded-md hover:bg-green-500/10 text-gray-400 hover:text-green-500 transition-colors" title="تشغيل">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                                @endif

                                @if($campaign->status == 'sending')
                                <form action="{{ route('whatsapp.campaigns.status', $campaign->id) }}" method="POST" class="inline-block">
                                    @csrf <input type="hidden" name="status" value="paused">
                                    <button class="p-1.5 rounded-md hover:bg-yellow-500/10 text-gray-400 hover:text-yellow-500 transition-colors" title="إيقاف مؤقت">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('whatsapp.campaigns.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('حذف؟')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 rounded-md hover:bg-red-500/10 text-gray-400 hover:text-red-500 transition-colors" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>لا توجد حملات حتى الآن</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($campaigns->hasPages())
    <div class="mt-4 flex justify-center">
        {{ $campaigns->links() }}
    </div>
    @endif

</div>
@endsection
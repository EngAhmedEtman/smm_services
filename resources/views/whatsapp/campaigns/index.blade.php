@extends('layouts.app')

@section('title', 'حملات واتساب | Etman SMM')

@section('header_title', 'حملات واتساب')

@section('content')
<div class="space-y-6">

    <div class="flex justify-between items-center bg-gray-900/50 p-4 rounded-xl border border-gray-800">
        <div>
            <h2 class="text-xl font-bold text-white">إدارة الحملات</h2>
            <p class="text-sm text-gray-400">تابع وإدر حملاتك الإعلانية عبر واتساب</p>
        </div>
        <a href="{{ route('whatsapp.campaigns.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-bold transition-all shadow-lg shadow-indigo-600/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            حملة جديدة
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-slide-in">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="glass overflow-hidden rounded-2xl border border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase">الحملة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase">المجموعة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase">الحالة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase">التقدم</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase">التأخير</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($campaigns as $campaign)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $campaign->campaign_name }}</div>
                            <div class="text-xs text-gray-500">{{ $campaign->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">
                            {{ $campaign->contact->contact_name ?? 'مجموعة محذوفة' }}
                            <span class="block text-xs text-gray-500">{{ $campaign->instance_id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($campaign->status == 'pending')
                            <span class="bg-yellow-500/10 text-yellow-500 px-2 py-1 rounded text-xs font-bold border border-yellow-500/20">قيد الانتظار</span>
                            @elseif($campaign->status == 'processing')
                            <span class="bg-blue-500/10 text-blue-500 px-2 py-1 rounded text-xs font-bold border border-blue-500/20 animate-pulse">جاري الإرسال...</span>
                            @elseif($campaign->status == 'completed')
                            <span class="bg-green-500/10 text-green-500 px-2 py-1 rounded text-xs font-bold border border-green-500/20">مكتمل</span>
                            @else
                            <span class="bg-red-500/10 text-red-500 px-2 py-1 rounded text-xs font-bold border border-red-500/20">{{ $campaign->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-400 mb-1 flex justify-between">
                                <span>{{ $campaign->sent_count }} / {{ $campaign->total_numbers }}</span>
                                <span>{{ $campaign->total_numbers > 0 ? round(($campaign->sent_count / $campaign->total_numbers) * 100) : 0 }}%</span>
                            </div>
                            <div class="w-24 h-1.5 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $campaign->total_numbers > 0 ? ($campaign->sent_count / $campaign->total_numbers) * 100 : 0 }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 font-mono">
                            {{ $campaign->min_delay }} - {{ $campaign->max_delay }}s
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                @if($campaign->status == 'pending' || $campaign->status == 'paused' || $campaign->status == 'processing')
                                <!-- Start / Resume Processing Page -->
                                {{-- We will create a process page next --}}
                                <!-- Start (Processing) -->
                                @if($campaign->status == 'pending' || $campaign->status == 'paused')
                                <form action="{{ route('whatsapp.campaigns.status', $campaign->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="text-green-500 hover:bg-green-500/10 px-2 py-1.5 rounded transition-all" title="بدء الإرسال (خلفية)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                                @endif

                                <!-- Open Screen (Monitoring) -->
                                <a href="{{ route('whatsapp.campaigns.process', $campaign->id) }}" class="text-blue-400 hover:bg-blue-500/10 px-2 py-1.5 rounded transition-all" title="شاشة المراقبة">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <!-- Pause / Resume Status Toggle -->
                                <form action="{{ route('whatsapp.campaigns.status', $campaign->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $campaign->status == 'paused' ? 'pending' : 'paused' }}">
                                    <button type="submit" class="text-yellow-400 hover:bg-yellow-500/10 px-2 py-1.5 rounded transition-all" title="{{ $campaign->status == 'paused' ? 'استئناف' : 'إيقاف مؤقت' }}">
                                        @if($campaign->status == 'paused')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        @endif
                                    </button>
                                </form>
                                @endif

                                <!-- Delete -->
                                <form action="{{ route('whatsapp.campaigns.destroy', $campaign->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحملة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:bg-red-500/10 px-2 py-1.5 rounded transition-all" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            لا توجد حملات حالياً. ابدأ بإنشاء حملة جديدة!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($campaigns->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $campaigns->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
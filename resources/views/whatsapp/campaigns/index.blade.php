@extends('layouts.app')

@section('title', 'حملات واتساب | Etman SMM')

@section('header_title', 'حملات واتساب')

@section('content')
<div class="space-y-8 direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 right-0 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total Campaigns -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden group hover:border-indigo-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-indigo-500/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl group-hover:bg-indigo-500/20 transition-all"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm font-medium mb-1">إجمالي الحملات</div>
                    <div class="text-3xl font-black text-white">{{ $campaigns->total() }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow-[0_0_10px_rgba(99,102,241,0.1)] group-hover:shadow-[0_0_20px_rgba(99,102,241,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Campaigns -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden group hover:border-green-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-500/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full blur-xl group-hover:bg-green-500/20 transition-all"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm font-medium mb-1">حملات نشطة</div>
                    <div class="text-3xl font-black text-green-400">{{ $campaigns->where('status', 'sending')->count() }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-white transition-all duration-300 shadow-[0_0_10px_rgba(34,197,94,0.1)] group-hover:shadow-[0_0_20px_rgba(34,197,94,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $campaigns->where('status', 'sending')->count() > 0 ? 'animate-pulse' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Campaigns -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden group hover:border-yellow-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-yellow-500/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full blur-xl group-hover:bg-yellow-500/20 transition-all"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm font-medium mb-1">قيد الانتظار</div>
                    <div class="text-3xl font-black text-yellow-400">{{ $campaigns->where('status', 'pending')->count() }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-yellow-500/10 flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-white transition-all duration-300 shadow-[0_0_10px_rgba(234,179,8,0.1)] group-hover:shadow-[0_0_20px_rgba(234,179,8,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed/Other -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 p-6 rounded-2xl relative overflow-hidden group hover:border-blue-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-500/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full blur-xl group-hover:bg-blue-500/20 transition-all"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm font-medium mb-1">مكتملة / أخرى</div>
                    <div class="text-3xl font-black text-blue-400">{{ $campaigns->whereIn('status', ['completed', 'failed', 'paused'])->count() }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 shadow-[0_0_10px_rgba(59,130,246,0.1)] group-hover:shadow-[0_0_20px_rgba(59,130,246,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#1e1e24]/60 backdrop-blur-md p-6 rounded-2xl border border-gray-800 relative z-10">
        <div>
            <h2 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                <span class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full inline-block"></span>
                إدارة الحملات الإعلانية
            </h2>
            <p class="text-gray-400 text-sm max-w-xl">أنشئ حملات واتساب متقدمة، راقب التقدم في الوقت الفعلي، وتحكم في عملية الإرسال بدقة.</p>
        </div>
        <a href="{{ route('whatsapp.campaigns.create') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-900/30 hover:shadow-indigo-900/50 hover:-translate-y-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:animate-shine"></div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>حملة جديدة</span>
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-4 rounded-xl flex items-center gap-3 animate-fade-in-up backdrop-blur-sm shadow-lg shadow-green-900/10">
        <div class="p-2 bg-green-500/20 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <p class="font-bold">تم بنجاح!</p>
            <p class="text-sm opacity-80">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Campaigns List -->
    <div class="space-y-4">

        @forelse($campaigns as $campaign)
        @php
        $statusClasses = [
        'pending' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
        'sending' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
        'paused' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
        'completed' => 'bg-green-500/10 text-green-400 border-green-500/20',
        'failed' => 'bg-red-500/10 text-red-400 border-red-500/20',
        ];
        $statusLabels = [
        'pending' => 'قيد الانتظار',
        'sending' => 'جاري الإرسال',
        'paused' => 'متوقف مؤقتاً',
        'completed' => 'مكتمل',
        'failed' => 'فشلت',
        ];
        $currentStatus = $campaign->status;
        $progress = $campaign->total_numbers > 0 ? round((($campaign->sent_count + $campaign->failed_count) / $campaign->total_numbers) * 100) : 0;
        $sentPercent = $campaign->total_numbers > 0 ? ($campaign->sent_count / $campaign->total_numbers) * 100 : 0;
        $failedPercent = $campaign->total_numbers > 0 ? ($campaign->failed_count / $campaign->total_numbers) * 100 : 0;
        @endphp

        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl p-5 hover:border-indigo-500/20 transition-all group">

            <!-- Top Row: Name + Status + Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all shrink-0 border border-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-white text-base truncate group-hover:text-indigo-300 transition-colors">{{ $campaign->campaign_name }}</h3>
                        <div class="flex items-center gap-3 text-xs text-gray-500 mt-0.5">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $campaign->contact->contact_name ?? 'محذوفة' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $campaign->created_at->diffForHumans() }}
                            </span>
                            <span class="font-mono text-gray-600" dir="ltr">
                                {{ $campaign->whatsappInstance ? $campaign->whatsappInstance->phone_number : 'ID: ' . $campaign->instance_id }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <!-- Status Badge -->
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold border flex items-center gap-1.5 {{ $statusClasses[$currentStatus] ?? 'bg-gray-700 text-gray-300' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current {{ $currentStatus === 'sending' ? 'animate-pulse' : '' }}"></span>
                        {{ $statusLabels[$currentStatus] ?? $currentStatus }}
                    </span>

                    <!-- Action Buttons -->
                    @if(in_array($campaign->status, ['pending', 'paused']))
                    <form action="{{ route('whatsapp.campaigns.status', $campaign->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="sending">
                        <button type="submit" class="w-8 h-8 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white flex items-center justify-center transition-all" title="بدء">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                    @endif

                    @if($campaign->status == 'sending')
                    <form action="{{ route('whatsapp.campaigns.status', $campaign->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="paused">
                        <button type="submit" class="w-8 h-8 rounded-lg bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500 hover:text-white flex items-center justify-center transition-all" title="إيقاف">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('whatsapp.campaigns.process', $campaign->id) }}" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-all" title="مراقبة">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <form action="{{ route('whatsapp.campaigns.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحملة؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all" title="حذف">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="bg-[#16161a]/60 rounded-xl p-3 border border-gray-800/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-4 text-xs font-bold">
                        <span class="text-green-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> {{ $campaign->sent_count }} مرسل</span>
                        <span class="text-red-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ $campaign->failed_count }} فشل</span>
                        <span class="text-gray-500">من {{ $campaign->total_numbers }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-[11px]">
                        <!-- Delay Info -->
                        <span class="text-gray-400 flex items-center gap-1 bg-gray-800/50 px-2 py-1 rounded-md border border-gray-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-mono">{{ $campaign->min_delay }}-{{ $campaign->max_delay }}ث</span>
                        </span>
                        @if($campaign->batch_size > 0)
                        <span class="text-amber-400/80 flex items-center gap-1 bg-amber-900/10 px-2 py-1 rounded-md border border-amber-800/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="font-mono">{{ $campaign->batch_size }} / {{ $campaign->batch_sleep }}د</span>
                        </span>
                        @endif
                        <span class="text-white font-bold font-mono">{{ $progress }}%</span>
                    </div>
                </div>
                <div class="w-full h-2 bg-gray-800 rounded-full overflow-hidden flex">
                    <div class="h-full bg-gradient-to-r from-green-600 to-green-400 transition-all duration-500" style="width: {{ $sentPercent }}%"></div>
                    <div class="h-full bg-red-500/50 transition-all duration-500" style="width: {{ $failedPercent }}%"></div>
                </div>
            </div>

        </div>
        @empty
        <!-- Empty State -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800 rounded-2xl px-6 py-24 text-center">
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="w-20 h-20 bg-gray-800/50 rounded-full flex items-center justify-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white mb-1">لا توجد حملات حتى الآن</h3>
                    <p class="text-gray-500 mb-6">ابدأ بإنشاء أول حملة واتساب للوصول إلى عملائك.</p>
                    <a href="{{ route('whatsapp.campaigns.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-indigo-900/40">
                        إنشاء حملة جديدة
                    </a>
                </div>
            </div>
        </div>
        @endforelse

    </div>

    @if($campaigns->hasPages())
    <div class="flex justify-center">
        {{ $campaigns->links() }}
    </div>
    @endif

</div>
@endsection
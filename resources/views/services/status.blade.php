@extends('layouts.app')

@section('title', 'سجل الطلبات | Etman SMM')
@section('header_title', 'سجل الطلبات')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 left-10 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <!-- Total -->
        <div class="bg-indigo-900/20 border border-indigo-500/20 p-4 rounded-xl flex flex-col items-center justify-center gap-2 relative overflow-hidden group hover:bg-indigo-900/30 transition-all duration-300">
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500/50 group-hover:h-1 transition-all"></div>
            <span class="text-xs text-indigo-300 font-bold uppercase tracking-wider">الكل</span>
            <span class="text-2xl font-bold text-white font-mono">{{ $orders->count() }}</span>
        </div>

        <!-- Completed -->
        <div class="bg-green-900/20 border border-green-500/20 p-4 rounded-xl flex flex-col items-center justify-center gap-2 relative overflow-hidden group hover:bg-green-900/30 transition-all duration-300">
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-green-500/50 group-hover:h-1 transition-all"></div>
            <span class="text-xs text-green-300 font-bold uppercase tracking-wider">مكتمل</span>
            <span class="text-2xl font-bold text-green-400 font-mono">{{ $orders->where('status', 'completed')->count() }}</span>
        </div>

        <!-- Pending -->
        <div class="bg-blue-900/20 border border-blue-500/20 p-4 rounded-xl flex flex-col items-center justify-center gap-2 relative overflow-hidden group hover:bg-blue-900/30 transition-all duration-300">
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-blue-500/50 group-hover:h-1 transition-all"></div>
            <span class="text-xs text-blue-300 font-bold uppercase tracking-wider">انتظار</span>
            <span class="text-2xl font-bold text-blue-400 font-mono">{{ $orders->where('status', 'pending')->count() }}</span>
        </div>

        <!-- Processing -->
        <div class="bg-yellow-900/20 border border-yellow-500/20 p-4 rounded-xl flex flex-col items-center justify-center gap-2 relative overflow-hidden group hover:bg-yellow-900/30 transition-all duration-300">
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500/50 group-hover:h-1 transition-all"></div>
            <span class="text-xs text-yellow-300 font-bold uppercase tracking-wider">معالجة</span>
            <span class="text-2xl font-bold text-yellow-400 font-mono">{{ $orders->whereIn('status', ['processing', 'inprogress', 'in progress'])->count() }}</span>
        </div>

        <!-- Canceled -->
        <div class="bg-red-900/20 border border-red-500/20 p-4 rounded-xl flex flex-col items-center justify-center gap-2 relative overflow-hidden group hover:bg-red-900/30 transition-all duration-300">
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-red-500/50 group-hover:h-1 transition-all"></div>
            <span class="text-xs text-red-300 font-bold uppercase tracking-wider">ملغي</span>
            <span class="text-2xl font-bold text-red-400 font-mono">{{ $orders->whereIn('status', ['canceled', 'cancelled', 'partial', 'failed'])->count() }}</span>
        </div>
    </div>

    <!-- Orders List -->
    <div class="flex flex-col gap-4">
        @forelse($orders as $order)
        <div class="bg-[#1a1a20]/80 backdrop-blur-sm border border-gray-800/60 rounded-xl p-4 relative hover:bg-[#202026]/90 transition-all duration-300 group shadow-lg hover:shadow-xl">

            <!-- Grid Container: Stack on Mobile, 12-Col Grid on Desktop -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                <!-- Mobile Only: Header Strip -->
                <div class="flex items-center justify-between md:hidden pb-4 border-b border-gray-700/50 mb-2 col-span-1">
                    <div class="flex items-center gap-2">
                        <span class="text-pink-500 font-mono font-bold bg-pink-500/10 px-2 py-0.5 rounded text-xs">#{{ $order->id }}</span>
                        <span class="text-gray-500 text-[10px]">{{ $order->created_at->format('Y-m-d') }}</span>
                    </div>
                    @php
                    $status = strtolower($order->status ?? 'unknown');
                    $statusColor = 'gray';
                    if(in_array($status, ['completed'])) $statusColor = 'green';
                    elseif(in_array($status, ['pending'])) $statusColor = 'blue';
                    elseif(in_array($status, ['processing', 'inprogress', 'in progress'])) $statusColor = 'yellow';
                    elseif(in_array($status, ['canceled', 'cancelled', 'failed'])) $statusColor = 'red';
                    elseif(in_array($status, ['partial'])) $statusColor = 'orange';
                    @endphp
                    <span class="text-{{ $statusColor }}-400 text-xs font-bold px-2 py-1 rounded bg-{{ $statusColor }}-500/10 border border-{{ $statusColor }}-500/20 capitalize">
                        {{ $order->status }}
                    </span>
                </div>

                <!-- Section 1: Service Info (Desktop: Span 5) -->
                <div class="md:col-span-5 flex flex-col gap-1.5 min-w-0">
                    <div class="flex items-center gap-2">
                        <!-- Desktop ID -->
                        <span class="hidden md:inline-block text-pink-500 font-mono font-bold bg-pink-500/10 px-2 py-0.5 rounded text-xs">#{{ $order->smm_order_id ?? $order->id }}</span>
                        <h3 class="text-white font-bold text-sm truncate group-hover:text-pink-200 transition-colors" title="{{ $order->service_name }}">
                            {{ $order->service_name ?? 'خدمة غير محددة' }}
                        </h3>
                    </div>

                    <!-- Link -->
                    <div class="bg-[#25252e]/50 rounded p-1.5 flex items-center gap-2 border border-gray-700/30 group-hover:border-gray-600/50 transition-colors w-fit max-w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        <a href="{{ $order->link }}" target="_blank" class="text-blue-400 hover:text-blue-300 text-xs truncate font-mono underline decoration-dotted transition-colors">
                            {{ Str::limit($order->link, 40) }}
                        </a>
                    </div>
                </div>

                <!-- Section 2: Stats (Desktop: Span 4) -->
                <div class="md:col-span-4 grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4 items-center border-t md:border-t-0 md:border-x border-gray-800/50 pt-3 md:pt-0 md:px-4">
                    <!-- Mobile: Boxy / Desktop: Clean Text -->
                    <div class="bg-[#25252e]/50 md:bg-transparent p-2 md:p-0 rounded border md:border-0 border-gray-700/30">
                        <span class="text-[10px] text-gray-500 block mb-0.5">الكمية</span>
                        <span class="text-white font-mono text-sm font-bold">{{ $order->quantity }}</span>
                    </div>
                    <div class="bg-[#25252e]/50 md:bg-transparent p-2 md:p-0 rounded border md:border-0 border-gray-700/30">
                        <span class="text-[10px] text-gray-500 block mb-0.5">التكلفة</span>
                        <span class="text-green-400 font-mono text-sm font-bold">{{ $order->price }} <span class="text-[9px]">ج.م</span></span>
                    </div>
                    <div class="bg-[#25252e]/50 md:bg-transparent p-2 md:p-0 rounded border md:border-0 border-gray-700/30 hidden md:block">
                        <span class="text-[10px] text-gray-500 block mb-0.5">المتبقي</span>
                        <span class="text-gray-300 font-mono text-sm">{{ $order->remains ?? '-' }}</span>
                    </div>
                    <!-- Mobile only fields for Start/Remains if needed could go here, keeping it compact -->
                </div>

                <!-- Section 3: Status & Actions (Desktop: Span 3) -->
                <div class="md:col-span-3 flex flex-row md:flex-col items-center md:items-end gap-3 justify-between md:justify-center h-full">

                    <!-- Desktop Status & Date -->
                    <div class="hidden md:flex flex-col items-end gap-1">
                        @php
                        // Status color logic reused
                        @endphp
                        <span class="text-{{ $statusColor }}-400 text-xs font-bold px-2 py-0.5 rounded-full bg-{{ $statusColor }}-500/10 border border-{{ $statusColor }}-500/20 capitalize shadow-sm">
                            {{ $order->status }}
                        </span>
                        <span class="text-[10px] text-gray-600 font-mono">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 w-full md:w-auto">
                        @if($order->refill_available)
                        <form action="{{ route('order.refill', $order->id) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full md:w-8 md:h-8 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 border border-purple-500/30 text-xs font-bold py-2 md:py-0 rounded transition-colors flex items-center justify-center" title="Refill">
                                <span>♻️</span> <span class="md:hidden ml-1">Refill</span>
                            </button>
                        </form>
                        @endif

                        @if($order->cancel_available)
                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full md:w-8 md:h-8 bg-red-600/20 hover:bg-red-600/30 text-red-400 border border-red-500/30 text-xs font-bold py-2 md:py-0 rounded transition-colors flex items-center justify-center" title="Cancel">
                                <span>❌</span> <span class="md:hidden ml-1">Cancel</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-[#1e1e24]/50 backdrop-blur rounded-2xl border border-gray-800/50">
            <div class="inline-flex bg-gray-800/50 p-4 rounded-full mb-4 border border-gray-700/50">
                <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-white font-bold text-lg">لا توجد طلبات حتى الآن</h3>
            <a href="{{ route('services.index') }}" class="inline-flex mt-6 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-500 hover:to-rose-500 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-lg shadow-pink-900/40 border border-white/10">طلب جديد</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center pt-6 pb-12">
        <!-- Assuming $orders is paginated, if not standard Laravel pagination links work -->
        <!-- If $orders is a collection, no links() method. Assuming it is Paginated from Controller based on previous file -->
        @if(method_exists($orders, 'links'))
        {{ $orders->links('pagination::tailwind') }}
        @endif
    </div>

</div>
@endsection
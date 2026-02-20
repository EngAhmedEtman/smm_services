@extends('layouts.app')

@section('title', 'كل الطلبات | Etman SMM')
@section('header_title', 'إدارة الطلبات')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                كل الطلبات
            </h1>
            <p class="text-gray-400 mt-1">عرض وتتبع جميع طلبات المستخدمين</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-violet-500/20 text-violet-400 border border-violet-500/30 text-sm font-bold px-3 py-1.5 rounded-full">
                {{ number_format($stats['total']) }} طلب إجمالي
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        <a href="{{ route('admin.orders.index') }}" class="glass p-4 rounded-xl hover:border-violet-500/30 border border-transparent transition-colors">
            <p class="text-xs text-gray-500 mb-1">الكل</p>
            <p class="text-2xl font-bold text-white">{{ number_format($stats['total']) }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="glass p-4 rounded-xl hover:border-yellow-500/30 border {{ request('status') === 'pending' ? 'border-yellow-500/40' : 'border-transparent' }} transition-colors">
            <p class="text-xs text-gray-500 mb-1">معلق</p>
            <p class="text-2xl font-bold text-yellow-400">{{ number_format($stats['pending']) }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="glass p-4 rounded-xl hover:border-blue-500/30 border {{ request('status') === 'processing' ? 'border-blue-500/40' : 'border-transparent' }} transition-colors">
            <p class="text-xs text-gray-500 mb-1">جارٍ</p>
            <p class="text-2xl font-bold text-blue-400">{{ number_format($stats['processing']) }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="glass p-4 rounded-xl hover:border-green-500/30 border {{ request('status') === 'completed' ? 'border-green-500/40' : 'border-transparent' }} transition-colors">
            <p class="text-xs text-gray-500 mb-1">مكتمل</p>
            <p class="text-2xl font-bold text-green-400">{{ number_format($stats['completed']) }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'partial']) }}" class="glass p-4 rounded-xl hover:border-orange-500/30 border {{ request('status') === 'partial' ? 'border-orange-500/40' : 'border-transparent' }} transition-colors">
            <p class="text-xs text-gray-500 mb-1">جزئي</p>
            <p class="text-2xl font-bold text-orange-400">{{ number_format($stats['partial']) }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'failed']) }}" class="glass p-4 rounded-xl hover:border-red-500/30 border {{ in_array(request('status'), ['failed','canceled','cancelled']) ? 'border-red-500/40' : 'border-transparent' }} transition-colors">
            <p class="text-xs text-gray-500 mb-1">فشل/ملغي</p>
            <p class="text-2xl font-bold text-red-400">{{ number_format($stats['failed']) }}</p>
        </a>
    </div>

    {{-- Filters --}}
    <div class="glass p-4 rounded-2xl">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="ابحث باسم المستخدم / الإيميل / الرابط / رقم الطلب..."
                class="flex-1 min-w-[220px] bg-[#16161a] border border-gray-700 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-violet-500 placeholder-gray-600">
            <select name="status" class="bg-[#16161a] border border-gray-700 text-gray-300 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-violet-500">
                <option value="">كل الحالات</option>
                <option value="pending" {{ request('status') === 'pending'     ? 'selected' : '' }}>معلق</option>
                <option value="processing" {{ request('status') === 'processing'  ? 'selected' : '' }}>جارٍ التنفيذ</option>
                <option value="inprogress" {{ request('status') === 'inprogress'  ? 'selected' : '' }}>قيد التنفيذ</option>
                <option value="completed" {{ request('status') === 'completed'   ? 'selected' : '' }}>مكتمل</option>
                <option value="partial" {{ request('status') === 'partial'     ? 'selected' : '' }}>جزئي</option>
                <option value="failed" {{ request('status') === 'failed'      ? 'selected' : '' }}>فشل</option>
                <option value="canceled" {{ request('status') === 'canceled'    ? 'selected' : '' }}>ملغي</option>
            </select>
            <button type="submit" class="bg-violet-600 hover:bg-violet-500 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                🔍 بحث
            </button>
            @if(request('search') || request('status'))
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                ✕ مسح
            </a>
            @endif
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">#</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">المستخدم</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">الخدمة</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">الرابط</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">الكمية</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">السعر</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">رقم SMM</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">الحالة</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-4 py-4">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/30">
                    @forelse($orders as $order)
                    <tr class="hover:bg-white/5 transition-colors">
                        {{-- ID --}}
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $order->id }}</td>

                        {{-- User --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-violet-500/20 flex items-center justify-center text-violet-400 text-xs font-bold flex-shrink-0">
                                    {{ mb_substr($order->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs text-white font-medium whitespace-nowrap">{{ $order->user->name ?? 'محذوف' }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $order->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Service --}}
                        <td class="px-4 py-3">
                            <p class="text-xs text-gray-300 max-w-[160px] truncate" title="{{ $order->service_name }}">{{ $order->service_name }}</p>
                            <p class="text-[10px] text-gray-600">ID: {{ $order->service_id }}</p>
                        </td>

                        {{-- Link --}}
                        <td class="px-4 py-3">
                            <a href="{{ $order->link }}" target="_blank"
                                class="text-xs text-indigo-400 hover:text-indigo-300 max-w-[180px] truncate block"
                                title="{{ $order->link }}" dir="ltr">
                                {{ Str::limit($order->link, 35) }}
                            </a>
                        </td>

                        {{-- Quantity --}}
                        <td class="px-4 py-3 text-xs text-gray-300 whitespace-nowrap">
                            {{ number_format($order->quantity) }}
                            @if($order->remains !== null && $order->remains > 0)
                            <span class="text-gray-600">(متبقي: {{ number_format($order->remains) }})</span>
                            @endif
                        </td>

                        {{-- Price --}}
                        <td class="px-4 py-3">
                            <span class="text-xs font-bold text-green-400 whitespace-nowrap">{{ number_format($order->price, 3) }}</span>
                        </td>

                        {{-- SMM Order ID --}}
                        <td class="px-4 py-3 text-xs text-gray-400" dir="ltr">
                            {{ $order->smm_order_id ?? '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3">
                            @php
                            $status = strtolower($order->status ?? 'pending');
                            $statusMap = [
                            'pending' => ['label' => 'معلق', 'cls' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20', 'dot' => 'bg-yellow-400 animate-pulse'],
                            'processing' => ['label' => 'جارٍ التنفيذ', 'cls' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', 'dot' => 'bg-blue-400 animate-pulse'],
                            'inprogress' => ['label' => 'قيد التنفيذ', 'cls' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', 'dot' => 'bg-blue-400 animate-pulse'],
                            'in progress'=> ['label' => 'قيد التنفيذ', 'cls' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', 'dot' => 'bg-blue-400 animate-pulse'],
                            'completed' => ['label' => 'مكتمل', 'cls' => 'bg-green-500/10 text-green-400 border-green-500/20', 'dot' => 'bg-green-400'],
                            'partial' => ['label' => 'جزئي', 'cls' => 'bg-orange-500/10 text-orange-400 border-orange-500/20', 'dot' => 'bg-orange-400'],
                            'failed' => ['label' => 'فشل', 'cls' => 'bg-red-500/10 text-red-400 border-red-500/20', 'dot' => 'bg-red-400'],
                            'canceled' => ['label' => 'ملغي', 'cls' => 'bg-gray-500/10 text-gray-400 border-gray-500/20', 'dot' => 'bg-gray-400'],
                            'cancelled' => ['label' => 'ملغي', 'cls' => 'bg-gray-500/10 text-gray-400 border-gray-500/20', 'dot' => 'bg-gray-400'],
                            ];
                            $s = $statusMap[$status] ?? ['label' => $order->status, 'cls' => 'bg-gray-500/10 text-gray-400 border-gray-500/20', 'dot' => 'bg-gray-400'];
                            @endphp
                            <span class="inline-flex items-center gap-1 text-xs font-medium border px-2 py-0.5 rounded-full {{ $s['cls'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
                                {{ $s['label'] }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="px-4 py-3 text-[10px] text-gray-500 whitespace-nowrap">
                            {{ $order->created_at->format('Y-m-d') }}<br>
                            <span class="text-gray-600">{{ $order->created_at->format('h:i A') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-16">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">لا توجد طلبات تطابق البحث</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-700/30">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
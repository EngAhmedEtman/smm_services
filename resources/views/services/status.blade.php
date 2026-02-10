@extends('layouts.app')

@section('title', 'سجل الطلبات | Etman SMM')

@section('header_title', 'سجل الطلبات')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Stats -->
    <div class="mb-6">
        @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
        @endif
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="glass p-4 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">إجمالي الطلبات</p>
                <p class="text-lg font-bold text-white">{{ $orders->count() }}</p>
            </div>
        </div>
        <div class="glass p-4 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">المكتملة</p>
                <p class="text-lg font-bold text-white">{{ $orders->where('status', 'completed')->count() }}</p>
            </div>
        </div>
        <div class="glass p-4 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">قيد الانتظار</p>
                <p class="text-lg font-bold text-white">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
        </div>

        <div class="glass p-4 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-yellow-500/20 flex items-center justify-center text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">قيد المعالجة</p>
                <p class="text-lg font-bold text-white">{{ $orders->whereIn('status', ['processing', 'inprogress', 'in progress'])->count() }}</p>
            </div>
        </div>

        <div class="glass p-4 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">ملغي/مسترجع</p>
                <p class="text-lg font-bold text-white">{{ $orders->whereIn('status', ['canceled', 'cancelled', 'partial', 'failed'])->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="glass rounded-2xl overflow-hidden shadow-2xl border border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right">
                <thead class="bg-gray-900/80 text-gray-400 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-4 py-4 text-xs">المعرف</th>
                        <th class="px-4 py-4 text-xs">التاريخ</th>
                        <th class="px-4 py-4 text-xs">الخدمة</th>
                        <th class="px-4 py-4 text-xs">الرابط</th>
                        <th class="px-4 py-4 text-xs">الكمية</th>
                        <th class="px-4 py-4 text-xs">البدء</th>
                        <th class="px-4 py-4 text-xs">المتبقي</th>
                        <th class="px-4 py-4 text-xs">التكلفة</th>
                        <th class="px-4 py-4 text-xs">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($orders as $order)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-4 py-3 font-mono text-indigo-400 text-xs font-bold">#{{ $order->smm_order_id ?? $order->id }}</td>

                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $order->created_at->format('Y-m-d') }}</td>

                        <td class="px-4 py-3 text-gray-300 text-xs" title="{{ $order->service_name ?? 'غير متوفر' }}">
                            {{ Str::limit($order->service_name ?? 'غير متوفر', 20, '...') }}
                        </td>

                        <td class="px-4 py-3 text-xs">
                            <a href="{{ $order->link }}" target="_blank" class="text-blue-400 hover:text-blue-300 underline decoration-dotted" title="{{ $order->link }}">
                                {{ Str::limit($order->link, 20, '...') }}
                            </a>
                        </td>

                        <td class="px-4 py-3 text-gray-300 font-mono text-xs">{{ $order->quantity }}</td>

                        <td class="px-4 py-3 text-gray-300 font-mono text-xs">{{ $order->start_count ?? '-' }}</td>

                        <td class="px-4 py-3 font-bold text-white text-xs">{{ $order->remains ?? '-' }}</td>

                        <td class="px-4 py-3 font-mono text-green-400 text-xs">
                            {{ number_format($order->price ?? 0, 2) }} <span class="text-[10px] text-gray-500">ج.م</span>
                        </td>

                        <td class="px-4 py-3">
                            @php
                            $status = $order->status ?? 'Unknown';

                            // Arabic Translation Map
                            $statusArabic = [
                            'completed' => 'مكتمل',
                            'processing' => 'قيد المعالجة',
                            'inprogress' => 'جاري التنفيذ',
                            'in progress' => 'جاري التنفيذ',
                            'pending' => 'قيد الانتظار',
                            'partial' => 'جزئي',
                            'canceled' => 'ملغي',
                            'cancelled' => 'ملغي',
                            'failed' => 'فشل',
                            'refill' => 'إعادة تعبئة',
                            'Completed' => 'مكتمل',
                            'Processing' => 'قيد المعالجة',
                            'Inprogress' => 'جاري التنفيذ',
                            'In progress' => 'جاري التنفيذ',
                            'Pending' => 'قيد الانتظار',
                            'Partial' => 'جزئي',
                            'Canceled' => 'ملغي',
                            'Failed' => 'فشل',
                            'Refill' => 'إعادة تعبئة',
                            ];

                            $statusClasses = [
                            'completed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                            'processing' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                            'inprogress' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                            'in progress' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                            'pending' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                            'partial' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                            'canceled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                            'cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                            'failed' => 'bg-red-500/10 text-red-500 border-red-500/20',
                            'refill' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                            'Completed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                            'Processing' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                            'In progress' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                            'Pending' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                            'Partial' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                            'Canceled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                            'Refill' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                            ];

                            $displayStatus = $statusArabic[$status] ?? $status;
                            $class = $statusClasses[strtolower($status)] ?? 'bg-gray-500/10 text-gray-500 border-gray-500/20';
                            @endphp
                            <div class="flex flex-col gap-1.5 items-end min-w-[120px]">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $class }} whitespace-nowrap">
                                    {{ $displayStatus }}
                                </span>

                                @if($order->last_refill_status)
                                <span class="text-[9px] text-gray-400 whitespace-nowrap">Refill: {{ $order->last_refill_status }}</span>
                                @endif

                                @if($order->refill_available || $order->cancel_available)
                                <div class="flex gap-1 mt-1">
                                    @if($order->refill_available)
                                    <form action="{{ route('order.refill', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-[10px] bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded transition-colors whitespace-nowrap" onclick="return confirm('هل أنت متأكد من طلب إعادة التعبئة؟')">
                                            🔄 Refill
                                        </button>
                                    </form>
                                    @endif

                                    @if($order->cancel_available)
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-[10px] bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition-colors whitespace-nowrap" onclick="return confirm('هل أنت متأكد من إلغاء الطلب؟')">
                                            ❌ إلغاء
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                لا توجد بيانات متاحة حالياً
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Static for now) -->
        <div class="bg-gray-900/50 border-t border-gray-800 px-6 py-4 flex items-center justify-between">
            <p class="text-xs text-gray-500">عرض 1 إلى {{ $orders->count() }} من أصل {{ $orders->count() }} طلب</p>
            <div class="flex gap-2">
                <button class="px-3 py-1 rounded-lg bg-gray-800 text-gray-500 hover:bg-gray-700 hover:text-white transition-colors disabled:opacity-50" disabled>السابق</button>
                <button class="px-3 py-1 rounded-lg bg-gray-800 text-gray-500 hover:bg-gray-700 hover:text-white transition-colors disabled:opacity-50" disabled>التالي</button>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'طلبات شحن الرصيد | Etman SMM')
@section('header_title', 'طلبات شحن الرصيد')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                طلبات شحن الرصيد
            </h1>
            <p class="text-gray-400 mt-1">إدارة ومراجعة طلبات شحن رصيد المستخدمين</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 text-sm font-bold px-3 py-1.5 rounded-full">
                {{ $recharges->where('status', 'pending')->count() }} طلب معلق
            </div>
        </div>
    </div>

    {{-- Success / Error Messages --}}
    @if(session('success'))
    <div class="glass border border-green-500/30 p-4 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-green-400 text-sm flex-1">{{ session('success') }}</p>
        <button @click="show = false" class="text-gray-500 hover:text-gray-300">✕</button>
    </div>
    @endif

    @if(session('error'))
    <div class="glass border border-red-500/30 p-4 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
        <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <p class="text-red-400 text-sm flex-1">{{ session('error') }}</p>
        <button @click="show = false" class="text-gray-500 hover:text-gray-300">✕</button>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass p-4 rounded-xl">
            <p class="text-xs text-gray-500 mb-1">إجمالي الطلبات</p>
            <p class="text-2xl font-bold text-white">{{ $recharges->count() }}</p>
        </div>
        <div class="glass p-4 rounded-xl">
            <p class="text-xs text-gray-500 mb-1">معلقة</p>
            <p class="text-2xl font-bold text-yellow-400">{{ $recharges->where('status', 'pending')->count() }}</p>
        </div>
        <div class="glass p-4 rounded-xl">
            <p class="text-xs text-gray-500 mb-1">مقبولة</p>
            <p class="text-2xl font-bold text-green-400">{{ $recharges->where('status', 'approved')->count() }}</p>
        </div>
        <div class="glass p-4 rounded-xl">
            <p class="text-xs text-gray-500 mb-1">مرفوضة</p>
            <p class="text-2xl font-bold text-red-400">{{ $recharges->where('status', 'rejected')->count() }}</p>
        </div>
    </div>

    {{-- Recharge Requests Table --}}
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">#</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">المستخدم</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">المبلغ</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">رقم المرسل</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">صورة التحويل</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">الحالة</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">التاريخ</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/30">
                    @forelse($recharges as $recharge)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $recharge->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 text-xs font-bold">
                                    {{ mb_substr($recharge->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm text-white font-medium">{{ $recharge->user->name ?? 'محذوف' }}</p>
                                    <p class="text-xs text-gray-500">{{ $recharge->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-green-400">{{ number_format($recharge->amount, 2) }} جنيه</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300" dir="ltr">{{ $recharge->sender_number }}</td>
                        <td class="px-6 py-4">
                            @if($recharge->proof_image)
                            <a href="{{ url('file/' . $recharge->proof_image) }}" target="_blank"
                                class="inline-flex items-center gap-1 text-indigo-400 hover:text-indigo-300 text-xs bg-indigo-500/10 px-2 py-1 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                عرض الصورة
                            </a>
                            @else
                            <span class="text-xs text-gray-600">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($recharge->status == 'pending')
                            <span class="inline-flex items-center gap-1 text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span> معلق
                            </span>
                            @elseif($recharge->status == 'approved')
                            <span class="inline-flex items-center gap-1 text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> مقبول
                            </span>
                            @elseif($recharge->status == 'rejected')
                            <span class="inline-flex items-center gap-1 text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> مرفوض
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $recharge->created_at->format('Y-m-d h:i A') }}</td>
                        <td class="px-6 py-4">
                            @if($recharge->status == 'pending')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.recharges.approve', $recharge->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/20 text-xs font-medium px-3 py-1.5 rounded-lg transition-all" onclick="return confirm('تأكيد قبول الطلب وإضافة الرصيد؟')">
                                        ✓ قبول
                                    </button>
                                </form>
                                <form action="{{ route('admin.recharges.reject', $recharge->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/20 text-xs font-medium px-3 py-1.5 rounded-lg transition-all" onclick="return confirm('تأكيد رفض الطلب؟')">
                                        ✕ رفض
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs text-gray-600">تم المراجعة</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">لا توجد طلبات شحن حتى الآن</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
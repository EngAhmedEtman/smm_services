@extends('layouts.app')

@section('title', 'شحن الرصيد | Etman SMM')

@section('header_title', 'شحن الرصيد')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-slide-in">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl space-y-1 animate-slide-in">
        @foreach($errors->all() as $error)
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ $error }}
        </div>
        @endforeach
    </div>
    @endif

    <!-- 1. Balance Card -->
    <div class="glass relative overflow-hidden rounded-2xl border border-gray-800 p-8 flex flex-col items-center justify-center text-center">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl -mr-16 -mb-16 pointer-events-none"></div>
        <div class="absolute top-0 left-0 w-32 h-32 bg-purple-500/5 rounded-full blur-2xl -ml-16 -mt-16 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 mb-4 transform -rotate-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <p class="text-gray-400 font-medium text-sm uppercase tracking-wider mb-1">رصيدك الحالي</p>

            <div class="flex items-start justify-center gap-1">
                <span class="text-5xl font-black text-white tracking-tight">{{ number_format(auth()->user()->balance ?? 0, 2) }}</span>
                <span class="text-lg text-gray-500 font-bold mt-2">ج.م</span>
            </div>
        </div>
    </div>

    <!-- 2. Payment Methods -->
    <div>
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 text-sm">1</span>
            وسيلة الدفع المتاحة
        </h3>

        <!-- Unified Payment Method Card -->
        <label class="relative cursor-pointer group block">
            <input type="radio" name="payment_method" value="unified_wallet" class="peer sr-only" checked>
            <div class="p-6 rounded-2xl bg-gray-900 border-2 border-indigo-500 peer-checked:bg-indigo-500/5 transition-all relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">موصى به</div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="text-center md:text-right">
                            <h4 class="font-bold text-white text-lg">المحافظ الإلكترونية & انستا باي (تحويل فوري)</h4>
                            <p class="text-gray-400 text-sm">نقبل التحويل من جميع المحافظ المصرية وتطبيق انستا باي.</p>
                        </div>
                    </div>

                    <!-- Logos Grid -->
                    <div class="flex items-center gap-2 bg-white/5 p-2 rounded-xl backdrop-blur-sm">
                        <div class="w-10 h-10 rounded-full bg-white p-1 shadow-sm flex items-center justify-center" title="Vodafone Cash">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Vodafone_logo_2017.svg/200px-Vodafone_logo_2017.svg.png" class="w-full h-full object-contain">
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white p-1 shadow-sm flex items-center justify-center" title="InstaPay">
                            <img src="https://play-lh.googleusercontent.com/lM_166d3-qZqG_zU5JkXGqu3Zk5Zq_ZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZq=w240-h480-rw" class="w-full h-full object-contain">
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white p-1.5 shadow-sm flex items-center justify-center" title="Orange Cash">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Orange_logo.svg/200px-Orange_logo.svg.png" class="w-full h-full object-contain">
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white p-1.5 shadow-sm flex items-center justify-center" title="Etisalat Cash">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Etisalat_Logo.svg/200px-Etisalat_Logo.svg.png" class="w-full h-full object-contain">
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white p-1.5 shadow-sm flex items-center justify-center" title="WE Pay">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/We_logo.svg/200px-We_logo.svg.png" class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </label>
    </div>

    <!-- 3. Transfer Info -->
    <div class="glass p-6 rounded-2xl border border-gray-800 space-y-6">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 text-sm">2</span>
            بيانات التحويل
        </h3>

        <!-- Wallet Numbers -->
        <div class="bg-gray-900 rounded-xl p-5 border border-gray-700/50 text-center">
            <p class="text-gray-400 text-sm mb-4">قم بتحويل المبلغ إلى أحد الأرقام التالية:</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between bg-gray-800 p-3 rounded-lg border border-gray-700">
                    <span class="text-gray-400 text-sm">محفظة 1</span>
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-xl text-white font-bold tracking-widest">01070191977</span>
                        <button onclick="navigator.clipboard.writeText('0123456789')" class="text-indigo-400 hover:text-white text-sm">نسخ</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Steps -->
        <div class="space-y-3">
            <h4 class="text-white font-bold text-sm">خطوات التأكيد:</h4>
            <div class="flex gap-3 text-sm text-gray-300 items-start">
                <span class="w-5 h-5 rounded-full bg-gray-700 flex items-center justify-center text-xs shrink-0 mt-0.5">1</span>
                <p>أرسل المبلغ إلى الرقم الموضح بالأعلى.</p>
            </div>
            <div class="flex gap-3 text-sm text-gray-300 items-start">
                <span class="w-5 h-5 rounded-full bg-gray-700 flex items-center justify-center text-xs shrink-0 mt-0.5">2</span>
                <p>اكتب رقم محفظتك التي قمت بالتحويل منها في الفورم بالأسفل.</p>
            </div>
            <div class="flex gap-3 text-sm text-gray-300 items-start">
                <span class="w-5 h-5 rounded-full bg-gray-700 flex items-center justify-center text-xs shrink-0 mt-0.5">3</span>
                <p>اكتب المبلغ الذي حولته بدقة.</p>
            </div>
            <div class="flex gap-3 text-sm text-gray-300 items-start">
                <span class="w-5 h-5 rounded-full bg-gray-700 flex items-center justify-center text-xs shrink-0 mt-0.5">4</span>
                <p>اضغط على زر "تأكيد الدفع" وانتظر مراجعة الطلب (عادة 5 دقائق).</p>
            </div>
        </div>
    </div>

    <!-- 4. Confirmation Form -->
    <div class="glass p-6 rounded-2xl border border-gray-800">
        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 text-sm">3</span>
            تأكيد الدفع
        </h3>

        <form action="{{ route('recharge.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Sender Number -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-400">رقم المحفظة المُحوِّل منها</label>
                    <input type="text" name="sender_number" placeholder="010xxxxxxx" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-left" required>
                </div>

                <!-- Amount -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-400">المبلغ المحول</label>
                    <div class="relative">
                        <input type="number" name="amount" placeholder="0.00" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-left pl-12" required>
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm">EGP</span>
                    </div>
                </div>
            </div>

            <!-- Proof Image -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-400">صورة إيصال التحويل (سكرين شوت)</label>
                <input type="file" name="proof_image" accept="image/*" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600 transition-all" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-600/20">
                تأكيد الدفع
            </button>
        </form>
    </div>

    <!-- 5. Payment History -->
    <div class="glass overflow-hidden rounded-2xl border border-gray-800 mt-12">
        <div class="p-6 border-b border-gray-800 bg-gray-900/50">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                سجل عمليات الدفع
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right bg-transparent">
                <thead class="bg-gray-800/50 text-gray-400">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">الرقم</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">المبلغ</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">التاريخ</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">الإيصال</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-gray-300">
                    @forelse($recharges as $recharge)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-sm font-mono text-gray-500">#{{ $recharge->id }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-white">{{ number_format($recharge->amount, 2) }} <span class="text-xs font-normal text-gray-500">EGP</span></td>
                        <td class="px-6 py-4 text-sm">{{ $recharge->created_at->format('Y-m-d h:i A') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($recharge->proof_image)
                            <a href="{{ url('file/' . $recharge->proof_image) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 underline text-xs font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                معاينة
                            </a>
                            @else
                            <span class="text-gray-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($recharge->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                قيد المراجعة
                            </span>
                            @elseif($recharge->status == 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                تم القبول
                            </span>
                            @elseif($recharge->status == 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                مرفوض
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            لا توجد عمليات دفع سابقة
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recharges->hasPages())
        <div class="bg-gray-900/50 px-6 py-4 border-t border-gray-800">
            {{ $recharges->links() }}
        </div>
        @endif
    </div>

    <!-- Support Footer -->
    <div class="text-center">
        <a href="{{ route('call-us') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white transition-colors text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            واجهت مشكلة؟ تواصل مع الدعم الفني
        </a>
    </div>

</div>

<script>
    function toggleMethod(method) {
        // Optional: Update wallet numbers based on method if they differ
        // For now they are static as per request "اي رقمين"
    }
</script>
@endsection
@extends('layouts.app')

@section('title', 'إعدادات المسؤول | Etman SMM')
@section('header_title', 'إعدادات المسؤول')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                إعدادات المسؤول
            </h1>
            <p class="text-gray-400 mt-1">إدارة بيانات إشعارات الواتساب والإعدادات العامة</p>
        </div>
        <span class="bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold px-3 py-1.5 rounded-full">
            🔒 Super Admin
        </span>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="glass border border-green-500/30 p-4 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-green-400 text-sm flex-1">{{ session('success') }}</p>
        <button @click="show = false" class="text-gray-500 hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- WhatsApp Sender Section --}}
            <div class="glass p-6 rounded-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">بيانات الحساب المرسل</h3>
                        <p class="text-xs text-gray-500">بيانات Wolfix API لإرسال الإشعارات</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Instance ID</label>
                        <input type="text" name="admin_whatsapp_instance_id"
                            value="{{ $settings['admin_whatsapp_instance_id'] ?? '' }}"
                            class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-green-500/50 focus:ring-1 focus:ring-green-500/30 transition-all outline-none"
                            placeholder="مثال: 67XXXX">
                        <p class="text-xs text-gray-600 mt-1">الـ Instance ID الخاص بحساب الواتساب المرسل</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Access Token</label>
                        <input type="text" name="admin_whatsapp_access_token"
                            value="{{ $settings['admin_whatsapp_access_token'] ?? '' }}"
                            class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-green-500/50 focus:ring-1 focus:ring-green-500/30 transition-all outline-none"
                            placeholder="مثال: 6983bXXXXX">
                        <p class="text-xs text-gray-600 mt-1">رمز الوصول الخاص بحسابك في Wolfix</p>
                    </div>
                </div>
            </div>

            {{-- Admin Receiver Section --}}
            <div class="glass p-6 rounded-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">بيانات المستقبل</h3>
                        <p class="text-xs text-gray-500">رقم الجوال الذي سيستقبل الإشعارات</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">رقم جوال المسؤول</label>
                        <input type="text" name="admin_receiver_number"
                            value="{{ $settings['admin_receiver_number'] ?? '' }}"
                            dir="ltr"
                            class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/30 transition-all outline-none"
                            placeholder="مثال: 20123456789">
                        <p class="text-xs text-gray-600 mt-1">الرقم بالصيغة الدولية بدون + (مثال: 20123456789)</p>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-xl p-4 mt-4">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-indigo-300">
                                <p class="font-medium mb-1">كيف يعمل النظام؟</p>
                                <ul class="text-xs text-indigo-400/80 space-y-1 list-disc list-inside">
                                    <li>عند طلب شحن رصيد جديد، يتم إرسال إشعار لهذا الرقم</li>
                                    <li>الإشعار يتضمن بيانات العميل والمبلغ وصورة التحويل</li>
                                    <li>يتم الإرسال عبر واتساب أوتوماتيكياً</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold px-8 py-3 rounded-xl transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-green-500/40 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                حفظ الإعدادات
            </button>
        </div>
    </form>

    {{-- Pricing Tiers Section --}}
    <div class="mt-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="w-1 h-8 bg-indigo-500 rounded-full"></span>
                شرائح تسعير الرسائل
            </h2>
            <button onclick="document.getElementById('addTierModal').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                إضافة شريحة جديدة
            </button>
        </div>

        <div class="glass overflow-hidden rounded-2xl border border-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gray-800/50 text-gray-400 text-sm uppercase tracking-wider">
                            <th class="px-6 py-4 font-medium">الحد الأدنى (رسائل)</th>
                            <th class="px-6 py-4 font-medium">الحد الأقصى (رسائل)</th>
                            <th class="px-6 py-4 font-medium">السعر (لكل رسالة)</th>
                            <th class="px-6 py-4 font-medium">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($tiers as $tier)
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="px-6 py-4 text-white font-mono text-lg">
                                <span class="bg-indigo-500/10 text-indigo-400 px-3 py-1 rounded-lg border border-indigo-500/20">
                                    {{ number_format($tier->min_count) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-white font-mono text-lg">
                                @if($tier->max_count)
                                <span class="bg-purple-500/10 text-purple-400 px-3 py-1 rounded-lg border border-purple-500/20">
                                    {{ number_format($tier->max_count) }}
                                </span>
                                @else
                                <span class="text-gray-500 italic">بـلا حـد (فأكثر)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-emerald-400 font-bold text-lg">
                                {{ number_format($tier->price_per_message, 2) }} <span class="text-xs text-gray-500 font-normal">ج.م</span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <button onclick='editTier(@json($tier))' class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all" title="تعديل">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.pricing.destroy', $tier) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الشريحة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>لا توجد شرائح تسعير مضافة بعد.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Custom Services Section --}}
    <div class="mt-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="w-1 h-8 bg-pink-500 rounded-full"></span>
                الخدمات المخصصة
            </h2>
            <button onclick="document.getElementById('addCustomServiceModal').classList.remove('hidden')"
                class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-pink-600/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                إضافة خدمة مخصصة
            </button>
        </div>

        <div class="glass overflow-hidden rounded-2xl border border-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gray-800/50 text-gray-400 text-sm uppercase tracking-wider">
                            <th class="px-6 py-4 font-medium">القسم</th>
                            <th class="px-6 py-4 font-medium">اسم الخدمة</th>
                            <th class="px-6 py-4 font-medium">السعر (للألف)</th>
                            <th class="px-6 py-4 font-medium">الكمية (أدني - أقصي)</th>
                            <th class="px-6 py-4 font-medium">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($customServices ?? [] as $service)
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="px-6 py-4 text-white">
                                <span class="bg-gray-700/50 px-3 py-1 rounded-lg text-sm">{{ $service->category }}</span>
                            </td>
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4 text-emerald-400 font-bold">
                                {{ number_format($service->rate, 4) }} <span class="text-xs text-gray-500 font-normal">$</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300 font-mono text-sm">
                                {{ number_format($service->min) }} - {{ number_format($service->max) }}
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <form action="{{ route('admin.customServices.destroy', $service->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p>لا توجد خدمات مخصصة مضافة بعد.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Custom Service Modal -->
<div id="addCustomServiceModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">إضافة خدمة مخصصة</h3>
            <p class="text-gray-400 text-sm mt-1">أدخل بيانات الخدمة الجديدة.</p>
        </div>

        <form action="{{ route('admin.customServices.store') }}" method="POST" class="space-y-4 text-right">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">اسم القسم</label>
                <input type="text" name="category" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="مثال: خدمات متنوعة">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">اسم الخدمة</label>
                <input type="text" name="name" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="اسم الخدمة">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">الوصف</label>
                <textarea name="description" rows="3" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all placeholder-gray-500" required placeholder="وصف الخدمة المخصصة..."></textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للألف ($)</label>
                <input type="number" step="0.0001" name="rate" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="1.50">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-400 text-sm font-bold mb-2">الحد الأدنى</label>
                    <input type="number" name="min" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="10">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm font-bold mb-2">الحد الأقصى</label>
                    <input type="number" name="max" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" required placeholder="10000">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addCustomServiceModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-pink-600/20">حفظ الخدمة</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Tier Modal -->
<div id="addTierModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">إضافة شريحة جديدة</h3>
            <p class="text-gray-400 text-sm mt-1">حدد نطاق الرسائل والسعر المناسب.</p>
        </div>

        <form action="{{ route('admin.pricing.store') }}" method="POST" class="space-y-4 text-right">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">من (الحد الأدنى)</label>
                <input type="number" name="min_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required placeholder="0">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">إلى (الحد الأقصى - اختياري)</label>
                <input type="number" name="max_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="اتركه فارغاً لجعله مفتوحاً">
                <p class="text-xs text-gray-600 mt-1">مثال: 1000. إذا تركته فارغاً سيعني "فأكثر".</p>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للرسالة (ج.م)</label>
                <input type="number" step="0.01" name="price_per_message" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required placeholder="0.50">
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addTierModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20">حفظ الشريحة</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Tier Modal -->
<div id="editTierModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24]">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-white">تعديل الشريحة</h3>
        </div>

        <form id="editTierForm" method="POST" class="space-y-4 text-right">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">من (الحد الأدنى)</label>
                <input type="number" id="edit_min_count" name="min_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">إلى (الحد الأقصى)</label>
                <input type="number" id="edit_max_count" name="max_count" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">السعر للرسالة (ج.م)</label>
                <input type="number" step="0.01" id="edit_price" name="price_per_message" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('editTierModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all">إلغاء</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20">تحديث</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editTier(tier) {
        document.getElementById('editTierModal').classList.remove('hidden');
        document.getElementById('edit_min_count').value = tier.min_count;
        document.getElementById('edit_max_count').value = tier.max_count;
        document.getElementById('edit_price').value = tier.price_per_message;
        document.getElementById('editTierForm').action = "/admin/pricing/" + tier.id;
    }
</script>
@endsection
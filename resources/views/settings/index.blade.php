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
</div>
@endsection
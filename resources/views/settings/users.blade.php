@extends('layouts.app')

@section('title', 'إدارة المستخدمين | Etman SMM')
@section('header_title', 'إدارة المستخدمين')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="glass p-6 rounded-2xl flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                إدارة المستخدمين
            </h1>
            <p class="text-gray-400 mt-1">عرض وإدارة حسابات المستخدمين</p>
        </div>
        <div class="bg-blue-500/20 text-blue-400 border border-blue-500/30 text-sm font-bold px-3 py-1.5 rounded-full">
            {{ $users->count() }} مستخدم
        </div>
    </div>

    {{-- Users Table --}}
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b border-gray-700/50 bg-gray-800/30">
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">العميل</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">البريد & الهاتف</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">الرصيد</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">WhatsApp API</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">الصلاحية</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">تاريخ التسجيل</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">عدد الرسائل</th>
                        <th class="px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/30">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/20">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ $user->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm text-gray-300 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->email }}
                                </span>
                                @if($user->phone)
                                <span class="text-sm text-gray-400 flex items-center gap-1.5 font-mono">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $user->phone }}
                                </span>
                                @else
                                <span class="text-xs text-gray-600 italic">-- لا يوجد هاتف --</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-emerald-400">{{ number_format($user->balance, 2) }} ج.م</span>
                                <span class="text-xs text-gray-500">إنفاق: {{ number_format($user->total_spent, 2) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->banned)
                            <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                محظور
                            </span>
                            @elseif(!$user->is_active)
                            <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                غير نشط
                            </span>
                            @else
                            <span class="bg-green-500/10 text-green-400 border border-green-500/20 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                نشط
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.users.toggle-api', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="relative inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold transition-all border
                                    {{ $user->allow_api_key 
                                        ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20 hover:bg-emerald-500 hover:text-white' 
                                        : 'bg-gray-700/30 text-gray-400 border-gray-600/30 hover:bg-gray-600 hover:text-white' 
                                    }}"
                                    title="{{ $user->allow_api_key ? 'اضغط للتعطيل' : 'اضغط للتفعيل' }}">

                                    @if($user->allow_api_key)
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>API مفعل</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                    <span>API معطل</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role == 'super_admin')
                            <span class="text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20 px-2.5 py-1 rounded-full">Super Admin</span>
                            @elseif($user->role == 'admin')
                            <span class="text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2.5 py-1 rounded-full">Admin</span>
                            @else
                            <span class="text-xs font-medium bg-gray-500/10 text-gray-400 border border-gray-500/20 px-2.5 py-1 rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500 font-mono">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 font-mono">{{ $user->total_messages_sent }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                {{-- Add Credit Button --}}
                                <button onclick="openAddCreditModal({{ $user->id }}, '{{ $user->name }}')"
                                    class="p-2 rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all border border-emerald-500/20 hover:border-emerald-500"
                                    title="إضافة رصيد">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                {{-- Ban/Unban Button --}}
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 rounded-lg transition-all border {{ $user->banned ? 'bg-gray-500/10 text-gray-400 hover:bg-gray-500 hover:text-white border-gray-500/20 hover:border-gray-500' : 'bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white border-red-500/20 hover:border-red-500' }}"
                                        title="{{ $user->banned ? 'تفعيل المستخدم' : 'حظر المستخدم' }}"
                                        onclick="return confirm('{{ $user->banned ? 'هل أنت متأكد من تفعيل هذا المستخدم؟' : 'هل أنت متأكد من حظر هذا المستخدم؟' }}')">
                                        @if(!$user->banned)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        @endif
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-gray-500 text-sm">لا يوجد مستخدمين مسجلين حالياً</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Credit Modal --}}
<div id="addCreditModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-6 border border-gray-700 w-full max-w-md shadow-2xl rounded-2xl bg-[#1e1e24] transform transition-all scale-100">
        <button onclick="document.getElementById('addCreditModal').classList.add('hidden')" class="absolute top-4 left-4 text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">إضافة رصيد</h3>
            <p class="text-gray-400 text-sm mt-1">اضافة رصيد للمستخدم <span id="modalUserName" class="text-white font-bold"></span></p>
        </div>

        <form id="addCreditForm" method="POST" class="space-y-4 text-right">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">المبلغ (ج.م)</label>
                <input type="number" step="0.01" name="amount" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-gray-600" required placeholder="0.00">
            </div>
            <div>
                <label class="block text-gray-400 text-sm font-bold mb-2">سبب الإضافة (ملاحظة)</label>
                <textarea name="reason" rows="3" class="w-full bg-[#16161a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-gray-600" required placeholder="اكتب سبب إضافة الرصيد... (سيظهر في الإشعار)"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addCreditModal').classList.add('hidden')" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all font-medium">إلغاء</button>
                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-500 hover:to-green-500 text-white font-bold px-8 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transform hover:-translate-y-0.5 transition-all">إضافة وإرسال إشعار</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddCreditModal(userId, userName) {
        const modal = document.getElementById('addCreditModal');
        const form = document.getElementById('addCreditForm');
        document.getElementById('modalUserName').textContent = userName;
        form.action = `/admin/users/${userId}/add-credit`;
        modal.classList.remove('hidden');
    }
</script>
@endsection
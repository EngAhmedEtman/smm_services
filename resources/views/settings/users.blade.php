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
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">#</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">الاسم</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">البريد</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">الرصيد</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">إجمالي الإنفاق</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">الصلاحية</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-4">تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/30">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <p class="text-sm text-white font-medium">{{ $user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-green-400">{{ number_format($user->balance ?? 0, 2) }} جنيه</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-300">{{ number_format($user->total_spent ?? 0, 2) }} جنيه</span>
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
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <p class="text-gray-500 text-sm">لا يوجد مستخدمين</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
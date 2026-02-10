@extends('layouts.app')

@section('title', 'قوالب الرسائل')

@section('header_title', 'قوالب الرسائل')

@section('content')
<div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white">قوالب الرسائل المحفوظة</h2>
        <a href="{{ route('whatsapp.messages.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            إضافة قالب جديد
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 border-b border-gray-800 text-sm uppercase">
                    <th class="px-6 py-3 font-medium">اسم القالب</th>
                    <th class="px-6 py-3 font-medium">عدد الرسائل</th>
                    <th class="px-6 py-3 font-medium text-right">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($messages as $message)
                <tr class="hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-white font-medium">{{ $message->name }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($message->content[0] ?? '', 50) }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-300">
                        <span class="bg-gray-800 px-2 py-1 rounded text-xs">{{ count($message->content) }} رسائل (تبديل)</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('whatsapp.messages.edit', $message->id) }}" class="text-blue-400 hover:bg-blue-500/10 px-2 py-1.5 rounded transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <form action="{{ route('whatsapp.messages.destroy', $message->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القالب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:bg-red-500/10 px-2 py-1.5 rounded transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                        لا توجد قوالب رسائل محفوظة بعد.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</div>
@endsection
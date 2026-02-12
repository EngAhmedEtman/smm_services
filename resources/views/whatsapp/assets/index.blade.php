@extends('layouts.app')

@section('title', 'أصول واتساب | Etman SMM')

@section('content')
<div class="space-y-8 direction-rtl">

    <!-- Background Glow -->
    <div class="fixed top-20 right-0 w-[400px] h-[400px] bg-green-600/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#1e1e24]/60 backdrop-blur-md p-6 rounded-2xl border border-green-500/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/5 to-transparent pointer-events-none"></div>
        <div>
            <h2 class="text-2xl font-bold text-white mb-1 flex items-center gap-2">
                <span class="w-2 h-8 bg-green-500 rounded-full inline-block"></span>
                إدارة النصوص والأصول
            </h2>
            <p class="text-gray-400 text-sm">أضف نصوصاً عشوائية ورسائل ترحيب ليتم استخدامها تلقائياً في حملاتك.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in-up shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Random Texts Section -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800/80 rounded-3xl p-6 relative overflow-hidden flex flex-col h-full">
            <div class="absolute top-0 left-0 w-24 h-24 bg-blue-500/5 rounded-br-full pointer-events-none"></div>

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <span class="bg-blue-500/20 text-blue-400 p-1.5 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v3.292a1 1 0 11-2 0V13.899a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        النصوص العشوائية
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">استخدم الكود <code class="bg-gray-800 text-blue-400 px-1 py-0.5 rounded dir-ltr">@{{random}}</code> في رسائلك لإدراج نص عشوائي.</p>
                </div>
            </div>

            @if(auth()->user()->role === 'super_admin')
            <form action="{{ route('admin.assets.storeRandom') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="text" class="flex-1 bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all placeholder-gray-600" placeholder="أضف نصاً عشوائياً جديداً..." required>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
            @endif

            <div class="space-y-3 flex-1 overflow-y-auto max-h-[400px] pr-2 custom-scrollbar">
                @forelse($randomTexts as $text)
                <div class="bg-[#16161a]/60 border border-gray-800 rounded-xl p-3 flex items-center justify-between group hover:border-blue-500/30 transition-colors">
                    <p class="text-gray-300 text-sm">{{ $text->text }}</p>
                    <form action="{{ route('admin.assets.destroyRandom', $text->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-600 hover:text-red-400 p-1 rounded transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500 text-sm">
                    لا توجد نصوص عشوائية مضافة بعد.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Welcome Texts Section -->
        <div class="bg-[#1e1e24]/60 backdrop-blur-md border border-gray-800/80 rounded-3xl p-6 relative overflow-hidden flex flex-col h-full">
            <div class="absolute top-0 left-0 w-24 h-24 bg-purple-500/5 rounded-br-full pointer-events-none"></div>

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <span class="bg-purple-500/20 text-purple-400 p-1.5 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                            </svg>
                        </span>
                        رسائل الترحيب
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">استخدم الكود <code class="bg-gray-800 text-purple-400 px-1 py-0.5 rounded dir-ltr">@{{welcome}}</code> في رسائلك لإدراج ترحيب متغير.</p>
                </div>
            </div>

            @if(auth()->user()->role === 'super_admin')
            <form action="{{ route('admin.assets.storeWelcome') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="text" class="flex-1 bg-[#16161a]/80 border border-gray-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all placeholder-gray-600" placeholder="أضف رسالة ترحيب جديدة..." required>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-3 rounded-xl font-bold transition-all shadow-lg shadow-purple-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
            @endif

            <div class="space-y-3 flex-1 overflow-y-auto max-h-[400px] pr-2 custom-scrollbar">
                @forelse($welcomeTexts as $text)
                <div class="bg-[#16161a]/60 border border-gray-800 rounded-xl p-3 flex items-center justify-between group hover:border-purple-500/30 transition-colors">
                    <p class="text-gray-300 text-sm">{{ $text->text }}</p>
                    @if(auth()->user()->role === 'super_admin')
                    <form action="{{ route('admin.assets.destroyWelcome', $text->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-600 hover:text-red-400 p-1 rounded transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
                @empty
                <div class="text-center py-8 text-gray-500 text-sm">
                    لا توجد رسائل ترحيب مضافة بعد.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
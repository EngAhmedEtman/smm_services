<aside class="w-64 glass border-r border-gray-800 hidden md:flex flex-col min-h-screen fixed top-0 bottom-0 z-40 bg-[#1e1e23]/90 backdrop-blur-xl">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-700/50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">E</div>
            <span class="text-xl font-bold text-white tracking-wide">EtmanSMM</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2">
        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">القائمة الرئيسية</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 shadow-md' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            لوحة التحكم
        </a>

        <a href="{{ route('addOrder') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('addOrder') || request()->routeIs('showForm') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 shadow-md' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            طلب جديد
        </a>

        <a href="{{ route('status') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            سجل الطلبات
        </a>
    </nav>

    <!-- User Profile (Bottom) -->
    <div class="p-4 border-t border-gray-700/50">
        <div class="flex items-center gap-3 p-2 rounded-lg bg-gray-800/50 border border-gray-700/50">
            <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">U</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">مستخدم تجريبي</p>
                <p class="text-xs text-indigo-400 truncate">$120.50</p>
            </div>
        </div>
    </div>
</aside>
<!-- Desktop Header -->
<header class="hidden md:flex items-center justify-between h-20 px-8 glass border-b border-gray-800 sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold text-white tracking-wide">@yield('header_title', 'لوحة التحكم')</h2>
    </div>

    <div class="flex items-center gap-6">
        <!-- Balance Pill -->
        <a href="#" class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/20 backdrop-blur-md shadow-lg shadow-green-900/10 hover:shadow-green-900/20 transition-all duration-300 transform hover:scale-105">
            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold mr-1">الرصيد</span>
            <span class="text-sm text-white font-bold tracking-wide font-mono">${{ number_format(auth()->user()->balance ?? 0, 2) }}</span>
        </a>

        <!-- Notifications -->
        <button class="relative group p-2 rounded-xl hover:bg-white/5 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-[#0f0f13] animate-bounce"></span>
        </button>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 transition-all duration-300 group">
                <div class="text-right hidden sm:block">
                    <p class="text-xs text-gray-400 font-medium group-hover:text-indigo-300 transition-colors">مرحباً</p>
                    <p class="text-sm font-bold text-white leading-none">{{ auth()->user()->name ?? 'User' }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 p-0.5 shadow-lg shadow-indigo-500/20">
                    <div class="w-full h-full rounded-full bg-[#1e1e24] flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->avatar ?? false)
                        <img src="{{ auth()->user()->avatar }}" alt="User" class="w-full h-full object-cover">
                        @else
                        <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                        @endif
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 group-hover:text-white transition-colors duration-300 transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translateY-2" x-transition:enter-end="opacity-100 translateY-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translateY-0" x-transition:leave-end="opacity-0 translateY-2" class="absolute left-0 mt-3 w-56 rounded-2xl bg-[#1e1e24] border border-gray-700/50 shadow-2xl py-2 z-50">
                <div class="px-4 py-3 border-b border-gray-700/50 mb-1">
                    <p class="text-sm text-white font-bold">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    الملف الشخصي
                </a>

                <a href="{{ route('profile.edit', ['tab' => 'settings']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    الإعدادات
                </a>

                <div class="border-t border-gray-700/50 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Header -->
<header class="md:hidden glass border-b border-gray-800 sticky top-0 z-30 h-16 flex items-center justify-between px-4">
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">E</div>
        <span class="font-bold text-white">EtmanSMM</span>
    </div>

    <div class="flex items-center gap-4">
        <!-- Balance Mobile -->
        <span class="text-xs text-green-400 font-bold">$120.50</span>

        <button class="text-gray-400 hover:text-white transform active:scale-95 transition-transform" onclick="alert('Menu functionality would go here')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</header>
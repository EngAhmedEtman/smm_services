<!-- Desktop Header -->
<header class="hidden md:flex items-center justify-between h-20 px-8 mb-6 sticky top-0 z-30 mx-0 glass border-b border-gray-700/50 backdrop-blur-2xl bg-[#16161a]/80 transition-all duration-300">
    <div class="flex items-center gap-8">
        <!-- Page Title / Breadcrumbs -->
        <h2 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400 tracking-wide">
            @yield('header_title', 'لوحة التحكم')
        </h2>

        <!-- Global Search (Visual) -->
        <div class="relative group hidden lg:block">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" placeholder="ابحث عن خدمة، طلب، أو مستخدم..." class="bg-[#0f0f13]/50 border border-gray-800 rounded-xl py-2.5 pr-11 pl-4 text-sm text-gray-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 w-80 transition-all group-hover:bg-[#0f0f13] group-hover:border-gray-700 placeholder-gray-600">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-xs text-gray-600 border border-gray-700 rounded px-1.5 py-0.5">Ctrl+K</span>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-5">
        <!-- Balance Pill -->
        <a href="{{ route('recharge') }}" class="hidden lg:flex items-center gap-4 pl-1 pr-5 py-1.5 rounded-full bg-[#0f0f13]/80 border border-gray-800 hover:border-indigo-500/30 transition-all duration-300 group shadow-lg shadow-black/20">
            <div class="flex flex-col text-right">
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-bold leading-tight group-hover:text-indigo-400 transition-colors">الرصيد الحالي</span>
                <span class="text-base text-white font-black tracking-wide font-mono leading-tight group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-indigo-400 group-hover:to-purple-400 transition-all">{{ number_format(auth()->user()->balance ?? 0, 2) }} <span class="text-xs font-sans font-medium text-gray-500">ج.م</span></span>
            </div>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center shadow-lg shadow-indigo-600/20 group-hover:shadow-indigo-600/40 transition-all group-hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-1.5 pr-2 py-1.5 rounded-full bg-[#0f0f13]/50 hover:bg-[#0f0f13] border border-gray-800 hover:border-gray-700 transition-all duration-300 group">
                <div class="text-right hidden sm:block px-2">
                    <p class="text-xs text-gray-400 font-bold group-hover:text-white transition-colors">{{ strtok(auth()->user()->name ?? 'User', ' ') }}</p>
                    <p class="text-[10px] text-indigo-500/80 font-medium truncate max-w-[80px]">Member</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-gray-700 to-gray-600 p-[2px] shadow-lg group-hover:from-indigo-500 group-hover:to-purple-600 transition-all duration-500">
                    <div class="w-full h-full rounded-full bg-[#1e1e24] flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->avatar ?? false)
                        <img src="{{ auth()->user()->avatar }}" alt="User" class="w-full h-full object-cover">
                        @else
                        <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                        @endif
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 group-hover:text-white transition-colors duration-300 transform mr-1" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translateY-2" x-transition:enter-end="opacity-100 translateY-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translateY-0" x-transition:leave-end="opacity-0 translateY-2" class="absolute left-0 mt-3 w-64 rounded-2xl bg-[#16161a] border border-gray-800 shadow-2xl overflow-hidden z-50 ring-1 ring-white/5">
                <div class="px-6 py-5 border-b border-gray-800 bg-gradient-to-b from-gray-800/20 to-transparent">
                    <p class="text-sm text-white font-bold">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 truncate mt-1 font-mono">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                </div>

                <div class="p-2 space-y-0.5">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-gray-400 hover:bg-indigo-500/10 hover:text-indigo-400 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        الملف الشخصي
                    </a>

                    <a href="{{ route('profile.edit', ['tab' => 'settings']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-gray-400 hover:bg-indigo-500/10 hover:text-indigo-400 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        الإعدادات
                    </a>
                </div>

                <div class="border-t border-gray-800 p-2 bg-red-500/5 mt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Header -->
<header class="md:hidden glass border-b border-gray-800/50 sticky top-0 z-30 h-[4.5rem] flex items-center justify-between px-4 bg-[#16161a]/95 backdrop-blur-xl transition-all duration-300">
    <div class="flex items-center gap-3">
        <button @click="mobileSidebarOpen = true" class="text-gray-400 hover:text-white transition-colors p-2 rounded-lg active:bg-white/10 hover:bg-white/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
        <a href="/" class="flex items-center gap-2 group">
            <div class="w-10 h-10 transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                <img src="{{ asset('images/logo/logo-orange.png') }}" alt="EtViral" class="w-full h-full object-contain">
            </div>
            <span class="text-xl font-bold tracking-wide"><span style="color: #7eaeff;">Et</span><span style="color: #F37021;">Viral</span></span>
        </a>
    </div>

    <div class="flex items-center gap-3">
        <!-- Balance Mobile (Refined) -->
        <a href="{{ route('recharge') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/20 active:scale-95 transition-transform">
            <span class="text-xs text-green-400 font-bold font-mono tracking-wide">{{ number_format(auth()->user()->balance ?? 0, 2) }}</span>
            <div class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse shadow-[0_0_8px_rgba(74,222,128,0.5)]"></div>
        </a>

        <!-- User Dropdown (Mobile) -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="relative group outline-none">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-gray-700 to-gray-600 p-[2px] shadow-lg active:scale-95 transition-all">
                    <div class="w-full h-full rounded-full bg-[#1e1e24] flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->avatar ?? false)
                        <img src="{{ auth()->user()->avatar }}" alt="User" class="w-full h-full object-cover">
                        @else
                        <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                        @endif
                    </div>
                </div>
            </button>

            <!-- Mobile Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-48 rounded-xl bg-[#1e1e24] border border-gray-700 shadow-2xl overflow-hidden z-50 origin-top-left">
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white text-right">الملف الشخصي</a>
                    <a href="{{ route('recharge') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white text-right">شحن الرصيد</a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-700 mt-1 pt-1">
                        @csrf
                        <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300">تسجيل الخروج</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
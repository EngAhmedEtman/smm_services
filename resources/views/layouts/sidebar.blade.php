<aside class="w-64 glass border-r border-gray-800 hidden md:flex flex-col min-h-screen fixed top-0 bottom-0 z-40 bg-[#1e1e23]/90 backdrop-blur-xl">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-700/50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">E</div>
            <span class="text-xl font-bold text-white tracking-wide">EtmanSMM</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2" x-data="{ 
        openSmm: {{ (request()->routeIs('services.*') || request()->routeIs('addOrder') || request()->routeIs('showForm') || request()->routeIs('status')) ? 'true' : 'false' }}, 
        openWhatsapp: {{ request()->routeIs('whatsapp.*') ? 'true' : 'false' }} 
    }">
        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">القائمة الرئيسية</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 shadow-md' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            لوحة التحكم
        </a>

        <!-- Social Media Dropdown -->
        <div>
            <button @click="openSmm = !openSmm" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    خدمات السوشيال ميديا
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': openSmm}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openSmm" x-collapse class="pl-4 space-y-1 mt-1">
                <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('services.index') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    كل الخدمات
                </a>
                <a href="{{ route('services.favorites') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('services.favorites') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    المفضلة
                </a>
                <a href="{{ route('showForm') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ (request()->routeIs('showForm') || request()->routeIs('addOrder')) ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    طلب جديد
                </a>
                <a href="{{ route('status') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('status') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    سجل الطلبات
                </a>
            </div>
        </div>

        <!-- WhatsApp Dropdown -->
        <div>
            <button @click="openWhatsapp = !openWhatsapp" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    واتساب
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': openWhatsapp}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openWhatsapp" x-collapse class="pl-4 space-y-1 mt-1">
                <a href="{{ route('whatsapp.accounts') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('whatsapp.accounts') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    جميع الحسابات
                </a>
                <a href="{{ route('whatsapp.contacts') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('whatsapp.contacts') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    جهات الاتصال
                </a>
                <a href="{{ route('whatsapp.buttons') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('whatsapp.buttons') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    الأزرار التفاعلية
                </a>
                <a href="{{ route('whatsapp.campaigns.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('whatsapp.campaigns.*') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    الحملات الإعلانية
                </a>
                <!-- Marketing Messages (Templates) -->
                <a href="{{ route('whatsapp.messages.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('whatsapp.messages.*') ? 'text-indigo-400 bg-white/5' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    الرسائل المحفوظة
                </a>
            </div>
        </div>

        <a href="{{ route('recharge') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('recharge') ? 'bg-green-600/20 text-green-400 border border-green-500/20 shadow-md' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            شحن الرصيد
        </a>

        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-6">الدعم</p>

        <a href="{{ route('call-us') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('call-us') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 shadow-md' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            تواصل معنا
        </a>

        <a href="{{ route('privacy-policy') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('privacy-policy') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 shadow-md' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            سياسة الخصوصية
        </a>
    </nav>

    <!-- User Profile (Bottom) -->
    <div class="p-4 border-t border-gray-700/50">
        <div class="flex items-center gap-3 p-2 rounded-lg bg-gray-800/50 border border-gray-700/50">
            <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">U</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">مستخدم تجريبي</p>
                <p class="text-xs text-indigo-400 truncate">120.50 ج.م</p>
            </div>
        </div>
    </div>
</aside>
<!-- Mobile Backdrop (with fade effect) -->
<div x-show="mobileSidebarOpen"
    @click="mobileSidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-900/80 z-40 md:hidden backdrop-blur-sm">
</div>

<!-- Sidebar Container -->
<aside :class="mobileSidebarOpen ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
    class="fixed top-0 right-0 bottom-0 w-64 glass border-l border-white/5 flex flex-col z-50 bg-[#16161a]/95 backdrop-blur-2xl transition-transform duration-500 cubic-bezier(0.4, 0, 0.2, 1) transform md:translate-x-0 h-full shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)]">

    <!-- Logo Section (Animated) -->
    <div class="h-24 flex items-center justify-between px-8 relative overflow-hidden group">
        <!-- Glow Effect behind Logo -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-indigo-500/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

        <div class="flex items-center gap-3 relative z-10">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[1px] shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/50 transition-all duration-300 group-hover:rotate-3 group-hover:scale-105">
                <div class="w-full h-full rounded-[10px] bg-[#16161a] flex items-center justify-center">
                    <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">E</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-bold text-white tracking-wide group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-gray-400 transition-all">EtViral</span>
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold ml-0.5">Pro Dashboard</span>
            </div>
        </div>

        <!-- Mobile Close Button -->
        <button @click="mobileSidebarOpen = false" class="md:hidden text-gray-400 hover:text-white transition-colors hover:rotate-90 duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Custom Scrollbar Style -->
    <style>
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>

    <!-- Navigation (Scrollable) -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 sidebar-scroll" x-data="{ 
        openSmm: {{ (request()->routeIs('services.*') || request()->routeIs('addOrder') || request()->routeIs('showForm') || request()->routeIs('status')) ? 'true' : 'false' }}, 
        openWhatsapp: {{ request()->routeIs('whatsapp.*') ? 'true' : 'false' }},
        openAdmin: {{ request()->routeIs('admin.*') ? 'true' : 'false' }} 
    }">

        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
            class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
                  {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/10 text-white shadow-lg shadow-indigo-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

            @if(request()->routeIs('dashboard'))
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-indigo-500 rounded-l-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'group-hover:text-indigo-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="font-medium tracking-wide group-hover:translate-x-[-4px] transition-transform duration-300">لوحة التحكم</span>
        </a>

        <!-- Section Title -->
        <div class="px-4 mt-8 mb-2">
            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">الخدمات</span>
        </div>

        <!-- SMM Services Dropdown -->
        <div class="relative">
            <button @click="openSmm = !openSmm"
                class="w-full group flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
                    {{ (request()->routeIs('services.*') || request()->routeIs('addOrder') || request()->routeIs('showForm') || request()->routeIs('status')) ? 'bg-gradient-to-r from-pink-600/20 to-rose-600/10 text-white shadow-lg shadow-pink-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

                @if(request()->routeIs('services.*') || request()->routeIs('addOrder') || request()->routeIs('showForm') || request()->routeIs('status'))
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-pink-500 rounded-l-full shadow-[0_0_10px_rgba(236,72,153,0.5)]"></div>
                @endif

                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ (request()->routeIs('services.*') || request()->routeIs('addOrder')) ? 'text-pink-400' : 'group-hover:text-pink-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="font-medium group-hover:translate-x-[-4px] transition-transform duration-300">الخدمات والطلبات</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" :class="{'rotate-180': openSmm}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="openSmm" x-collapse class="pr-6 space-y-1 mt-1 overflow-hidden">
                <div class="border-r-2 border-gray-800 space-y-1 py-1 mr-3">
                    <a href="{{ route('addOrder') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ (request()->routeIs('addOrder') || request()->routeIs('services.add') || request()->is('services/add') || request()->is('new-order')) ? 'bg-pink-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ (request()->routeIs('addOrder') || request()->routeIs('services.add') || request()->is('services/add') || request()->is('new-order')) ? 'bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        طلب جديد
                    </a>
                    <a href="{{ route('services.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('services.index') ? 'bg-pink-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('services.index') ? 'bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        جميع الخدمات
                    </a>
                    <a href="{{ route('services.favorites') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('services.favorites') ? 'bg-pink-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('services.favorites') ? 'bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        المفضلة
                    </a>
                    <a href="{{ route('status') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('status') ? 'bg-pink-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('status') ? 'bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        سجل الطلبات
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Title -->
        <div class="px-4 mt-8 mb-2">
            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">التسويق</span>
        </div>

        <!-- WhatsApp Dropdown -->
        <div class="relative">
            <button @click="openWhatsapp = !openWhatsapp"
                class="w-full group flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
                    {{ request()->routeIs('whatsapp.*') ? 'bg-gradient-to-r from-green-600/20 to-emerald-600/10 text-white shadow-lg shadow-green-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

                @if(request()->routeIs('whatsapp.*'))
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-green-500 rounded-l-full shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
                @endif

                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('whatsapp.*') ? 'text-green-400' : 'group-hover:text-green-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="font-medium group-hover:translate-x-[-4px] transition-transform duration-300">واتساب</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" :class="{'rotate-180': openWhatsapp}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="openWhatsapp" x-collapse class="pr-6 space-y-1 mt-1 overflow-hidden">
                <div class="border-r-2 border-gray-800 space-y-1 py-1 mr-3">
                    <a href="{{ route('whatsapp.accounts') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('whatsapp.accounts') ? 'bg-green-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('whatsapp.accounts') ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        جميع الحسابات
                    </a>
                    <a href="{{ route('whatsapp.contacts') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('whatsapp.contacts') ? 'bg-green-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('whatsapp.contacts') ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        جهات الاتصال
                    </a>
                    <a href="{{ route('whatsapp.messages.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('whatsapp.messages.*') ? 'bg-green-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('whatsapp.messages.*') ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        الرسائل المحفوظة
                    </a>
                    <a href="{{ route('whatsapp.buttons') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('whatsapp.buttons') ? 'bg-green-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('whatsapp.buttons') ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        الأزرار التفاعلية
                    </a>
                    <a href="{{ route('whatsapp.campaigns.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('whatsapp.campaigns.*') ? 'bg-green-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('whatsapp.campaigns.*') ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        الحملات التسويقية
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Title -->
        <div class="px-4 mt-8 mb-2">
            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">المالية</span>
        </div>

        <!-- Funds Link -->
        <a href="{{ route('recharge') }}"
            class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
           {{ request()->routeIs('recharge') ? 'bg-gradient-to-r from-emerald-600/20 to-teal-600/10 text-white shadow-lg shadow-emerald-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

            @if(request()->routeIs('recharge'))
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-emerald-500 rounded-l-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('recharge') ? 'text-emerald-400' : 'group-hover:text-emerald-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium tracking-wide group-hover:translate-x-[-4px] transition-transform duration-300">شحن الرصيد</span>
        </a>




        @if(in_array(auth()->user()->role ?? 'user', ['admin', 'super_admin']))
        <!-- Admin Section (Only for Admins) -->
        <div class="px-4 mt-8 mb-2">
            <span class="text-[10px] font-bold text-red-500/80 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                الإدارة
            </span>
        </div>

        <div class="relative">
            <button @click="openAdmin = !openAdmin"
                class="w-full group flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
                    {{ request()->routeIs('admin.*') ? 'bg-gradient-to-r from-red-600/20 to-orange-600/10 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

                @if(request()->routeIs('admin.*'))
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-red-500 rounded-l-full shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>
                @endif

                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.*') ? 'text-red-500' : 'group-hover:text-red-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium group-hover:translate-x-[-4px] transition-transform duration-300">الإعدادات العامة</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" :class="{'rotate-180': openAdmin}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="openAdmin" x-collapse class="pr-6 space-y-1 mt-1 overflow-hidden">
                <div class="border-r-2 border-gray-800 space-y-1 py-1 mr-3">
                    <a href="{{ route('admin.settings.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.settings.index') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.settings.index') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        عام
                    </a>
                    <a href="{{ route('admin.recharges.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.recharges.index') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.recharges.index') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        طلبات الشحن
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.users.index') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users.index') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        المستخدمين
                    </a>
                    <a href="{{ route('admin.tickets.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.tickets.index') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.tickets.index') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        التذاكر
                    </a>
                    <a href="{{ route('admin.assets.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.assets.*') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.assets.*') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        إدارة المتغيرات
                    </a>
                    <a href="{{ route('admin.controlServices.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.controlServices.*') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.controlServices.*') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        التحكم في الخدمات
                    </a>
                    <a href="{{ route('admin.controlCategories.index') }}" class="group/sub flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.controlCategories.*') ? 'bg-red-500/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.controlCategories.*') ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : 'bg-gray-700 group-hover/sub:bg-gray-500' }} transition-all"></span>
                        التحكم في الأقسام
                    </a>

                </div>
            </div>
        </div>
        @endif

        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-6">الدعم</p>



        @if(auth()->user()->allow_api_key)
        <a href="{{route('create-token')}}"
            class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
            {{ request()->routeIs('create-token') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/10 text-white shadow-lg shadow-indigo-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

            @if(request()->routeIs('create-token'))
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-indigo-500 rounded-l-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('create-token') ? 'text-indigo-400' : 'group-hover:text-indigo-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            <span class="font-medium tracking-wide group-hover:translate-x-[-4px] transition-transform duration-300">واتساب API</span>
        </a>
        @else
        <a href="javascript:void(0)"
            onclick="showWhatsAppRedirect()"
            class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden text-gray-400 hover:text-white hover:bg-white/5">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 group-hover:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            <span class="font-medium tracking-wide group-hover:translate-x-[-4px] transition-transform duration-300">واتساب API</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </a>

        <script>
            function showWhatsAppRedirect() {
                // عرض الإشعار
                showGlobalNotification('هذه الخدمة غير متاحة لحسابكم حاليا، سيتم تحويلكم للإدارة للتواصل على واتساب...', 'info', 'جاري التحويل');

                // بعد 5 ثواني، فتح WhatsApp
                setTimeout(function() {
                    window.open('https://wa.me/201558551073?text=مرحباً، أرغب في تفعيل الوصول لخدمة واتساب API', '_blank');
                }, 5000);
            }
        </script>
        @endif

        <a href="{{ route('call-us') }}"
            class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
           {{ request()->routeIs('call-us') ? 'bg-gradient-to-r from-cyan-600/20 to-blue-600/10 text-white shadow-lg shadow-cyan-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

            @if(request()->routeIs('call-us'))
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-cyan-500 rounded-l-full shadow-[0_0_10px_rgba(6,182,212,0.5)]"></div>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('call-us') ? 'text-cyan-400' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span class="font-medium tracking-wide group-hover:translate-x-[-4px] transition-transform duration-300">تواصل معنا</span>
        </a>



        <a href="{{ route('privacy-policy') }}"
            class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 relative overflow-hidden
           {{ request()->routeIs('privacy-policy') ? 'bg-gradient-to-r from-violet-600/20 to-purple-600/10 text-white shadow-lg shadow-violet-900/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

            @if(request()->routeIs('privacy-policy'))
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-violet-500 rounded-l-full shadow-[0_0_10px_rgba(139,92,246,0.5)]"></div>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('privacy-policy') ? 'text-violet-400' : 'group-hover:text-violet-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="font-medium tracking-wide group-hover:translate-x-[-4px] transition-transform duration-300">سياسة الخصوصية</span>
        </a>

    </nav>

    <!-- User Profile (Bottom) -->
    <!-- User Profile (Bottom) Hidden/Removed as per request -->
    <!-- <div class="p-4 border-t border-gray-700/50"> ... </div> -->
</aside>
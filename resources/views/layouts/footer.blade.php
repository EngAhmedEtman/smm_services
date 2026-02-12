<footer class="mt-auto border-t border-gray-800/50 bg-[#16161a]/50 backdrop-blur-sm pt-6 pb-4 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Brand / About -->
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-500/20">E</div>
                <span class="text-base font-bold text-white tracking-wide">EtViral</span>
            </div>
            <p class="text-[13px] text-gray-400 leading-snug">
                منصتك الأولى لخدمات التسويق الإلكتروني المتكاملة. نقدم حلولاً ذكية لتعزيز تواجدك الرقمي.
            </p>
            <div class="flex gap-2.5 pt-1">
                <a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors transform hover:-translate-y-0.5">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors transform hover:-translate-y-0.5">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-pink-400 transition-colors transform hover:-translate-y-0.5">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.379-.06 3.808-.06zm0 1.838h-.633c-2.445 0-2.76.01-3.696.053-.93.041-1.433.197-1.769.328-.445.172-.76.377-1.092.709-.333.332-.538.647-.71.996-.131-.435.287-.838-.328-1.768.043-.936.053-1.251.053-3.696v-.633c0-2.445-.01-2.76-.053-3.696-.041-.93-.197-1.433-.328-1.769-.172-.445-.377-.76-.709-1.092-.332-.333-.647-.538-.996-.71-.435-.131-.838-.287-1.768-.328-.936-.043-1.251-.053-3.696-.053zM12.315 7.126a4.908 4.908 0 110 9.816 4.908 4.908 0 010-9.816zm0 1.838a3.07 3.07 0 100 6.14 3.07 3.07 0 000-6.14zM18.845 5.657a1.226 1.226 0 110 2.451 1.226 1.226 0 010-2.451z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Links Columns -->
        <div>
            <h3 class="text-white font-bold mb-2.5 border-r-2 border-indigo-500 pr-2.5 text-[13px]">روابط سريعة</h3>
            <ul class="space-y-1.5 text-[13px] text-gray-400">
                @auth
                <li><a href="{{ route('dashboard') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">لوحة التحكم</a></li>
                <li><a href="{{ route('services.index') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">جميع الخدمات</a></li>
                <li><a href="{{ route('addOrder') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">طلب جديد</a></li>
                @else
                <li><a href="{{ url('/') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">الرئيسية</a></li>
                <li><a href="{{ route('public.services') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">الخدمات</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">تسجيل الدخول</a></li>
                @endauth
                <li><a href="{{ route('recharge') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">شحن الرصيد</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-bold mb-2.5 border-r-2 border-purple-500 pr-2.5 text-[13px]">الدعم والمساعدة</h3>
            <ul class="space-y-1.5 text-[13px] text-gray-400">
                @auth
                <li><a href="{{ route('tickets.index') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">تذاكر الدعم الفني</a></li>
                @else
                <li><a href="{{ route('call-us') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">اتصل بنا</a></li>
                @endauth
                <li><a href="{{ route('terms') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">الشروط والأحكام</a></li>
                <li><a href="{{ route('privacy-policy') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">سياسة الخصوصية</a></li>
                <li><a href="{{ route('api.docs') }}" class="hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">API Documentation</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div>
            <h3 class="text-white font-bold mb-2.5 border-r-2 border-green-500 pr-2.5 text-[13px]">تواصل معنا</h3>
            <ul class="space-y-2 text-[13px] text-gray-400">
                <li class="flex items-center gap-2.5">
                    <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>support@etviral.com</span>
                </li>
                <li class="flex items-center gap-2.5">
                    <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>القاهرة، مصر</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-800/50 pt-4 flex flex-col md:flex-row items-center justify-between gap-3 text-[11px] text-gray-500">
        <p>&copy; {{ date('Y') }} <span class="text-gray-300 font-bold">EtViral</span>. جميع الحقوق محفوظة.</p>
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                جميع الأنظمة تعمل بكفاءة
            </span>
        </div>
    </div>
</footer>
@extends('layouts.app')

@section('title', 'تواصل معنا | Etman SMM')

@section('header_title', 'تواصل معنا')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 mb-6 shadow-lg shadow-purple-500/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">نحن هنا لمساعدتك</h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">فريقنا جاهز للإجابة على جميع استفساراتك ومساعدتك في الحصول على أفضل خدمات التسويق عبر وسائل التواصل الاجتماعي.</p>
    </div>

    <!-- Contact Cards -->
    <div class="grid md:grid-cols-2 gap-6 mb-12">
        <!-- WhatsApp -->
        <a href="https://wa.me/201234567890" target="_blank" class="glass p-6 rounded-2xl border border-gray-800 hover:border-green-500/50 transition-all duration-300 group hover:shadow-lg hover:shadow-green-500/10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-green-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">واتساب</h3>
                    <p class="text-gray-400 text-sm">تحدث معنا مباشرة على واتساب</p>
                    <p class="text-green-400 font-mono text-sm mt-1">+20 15 5855 1037</p>
                </div>
            </div>
        </a>

        <!-- Telegram -->
        <a href="https://t.me/etman_smm" target="_blank" class="glass p-6 rounded-2xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 group hover:shadow-lg hover:shadow-blue-500/10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-blue-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">تيليجرام</h3>
                    <p class="text-gray-400 text-sm">تابعنا على قناة التيليجرام</p>
                    <p class="text-blue-400 font-mono text-sm mt-1">@EtViral</p>
                </div>
            </div>
        </a>

        <!-- Email -->
        <a href="mailto:support@etviral.com" class="glass p-6 rounded-2xl border border-gray-800 hover:border-purple-500/50 transition-all duration-300 group hover:shadow-lg hover:shadow-purple-500/10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-purple-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">البريد الإلكتروني</h3>
                    <p class="text-gray-400 text-sm">راسلنا عبر البريد الإلكتروني</p>
                    <p class="text-purple-400 font-mono text-sm mt-1">support@EtViral.com</p>
                </div>
            </div>
        </a>

        <!-- Support Hours -->
        <div class="glass p-6 rounded-2xl border border-gray-800">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-orange-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">ساعات العمل</h3>
                    <p class="text-gray-400 text-sm">نحن متاحون على مدار الساعة</p>
                    <p class="text-orange-400 font-bold text-sm mt-1">24/7 دعم فني</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="glass rounded-2xl p-8 border border-gray-800">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">الأسئلة الشائعة</h2>

        <div class="space-y-4">
            <div class="bg-gray-800/50 rounded-xl p-4">
                <h3 class="text-white font-bold mb-2">كيف يمكنني شحن رصيدي؟</h3>
                <p class="text-gray-400 text-sm">يمكنك شحن رصيدك عبر التحويل البنكي أو المحافظ الإلكترونية. تواصل معنا للحصول على بيانات الدفع.</p>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-4">
                <h3 class="text-white font-bold mb-2">كم تستغرق الطلبات للبدء؟</h3>
                <p class="text-gray-400 text-sm">معظم الطلبات تبدأ خلال دقائق من التأكيد. بعض الخدمات قد تستغرق حتى 24 ساعة حسب نوع الخدمة.</p>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-4">
                <h3 class="text-white font-bold mb-2">هل الخدمات آمنة لحسابي؟</h3>
                <p class="text-gray-400 text-sm">نعم، جميع خدماتنا آمنة ومتوافقة مع سياسات منصات التواصل الاجتماعي.</p>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-4">
                <h3 class="text-white font-bold mb-2">ماذا لو لم يكتمل طلبي؟</h3>
                <p class="text-gray-400 text-sm">في حالة عدم اكتمال الطلب، سيتم رد المبلغ المتبقي تلقائياً إلى رصيدك أو يمكنك طلب إعادة التعبئة.</p>
            </div>
        </div>
    </div>
</div>
@endsection
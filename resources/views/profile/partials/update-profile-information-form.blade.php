<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('معلومات الملف الشخصي') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __("قم بتحديث معلومات ملفك الشخصي وعنوان بريدك الإلكتروني.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-300">{{ __('الاسم') }}</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full bg-[#16161a] border border-gray-700 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300">{{ __('البريد الإلكتروني') }}</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full bg-[#16161a] border border-gray-700 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-300">
                    {{ __('عنوان بريدك الإلكتروني غير مؤكد.') }}

                    <button form="send-verification" class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('انقر هنا لإعادة إرسال رسالة التأكيد.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-400">
                    {{ __('تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-300">{{ __('رقم الهاتف') }}</label>
            <input id="phone" name="phone" type="text" class="mt-1 block w-full bg-[#16161a] border border-gray-700 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2" value="{{ old('phone', $user->phone) }}" required />
            @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-indigo-500/30">
                {{ __('حفظ التغييرات') }}
            </button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-400">{{ __('تم الحفظ.') }}</p>
            @endif
        </div>
    </form>
</section>
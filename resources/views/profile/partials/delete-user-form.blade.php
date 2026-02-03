<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-500">
            {{ __('حذف الحساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.') }}
        </p>
    </header>

    <div x-data="{ open: false }">
        <button @click="open = true" type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-red-500/20">
            {{ __('حذف الحساب') }}
        </button>

        <!-- Modal -->
        <div x-show="open"
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-md bg-[#1e1e24] border border-gray-700 rounded-2xl shadow-2xl p-6"
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                <h2 class="text-lg font-medium text-white mb-4">
                    {{ __('هل أنت متأكد أنك تريد حذف حسابك؟') }}
                </h2>

                <p class="text-sm text-gray-400 mb-6">
                    {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف حسابك بشكل دائم.') }}
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-6">
                        <label for="password" class="sr-only">{{ __('كلمة المرور') }}</label>
                        <input id="password" name="password" type="password" class="block w-full bg-[#16161a] border border-gray-700 text-white rounded-lg focus:ring-red-500 focus:border-red-500 px-4 py-2" placeholder="{{ __('كلمة المرور') }}" required />
                        @error('password', 'userDeletion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                            {{ __('إلغاء') }}
                        </button>

                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-lg shadow-red-500/20">
                            {{ __('حذف الحساب') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<x-guest-layout>
    <div class="md:w-1/2 p-8 flex flex-col items-right">
        <h2 class="text-2xl font-bold text-gray-900 text-right">
            Hello! 👋
        </h2>
        <p class="text-gray-600 text-center">Silahkan login terlebih dahulu</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email/NIM/NIP Input -->
            <div class="mt-6">
                <x-input-label for="login" :value="__('E-mail, NIM, NIP')" />
                <x-text-input id="login" class="block mt-2 px-70 py-2 focus:ring-[#15406A] focus:border-[#15406A] rounded-full border-gray-300" type="text" name="login"
                    :value="old('login')" required autofocus placeholder="E-mail, NIM, NIP" />
                <x-input-error :messages="$errors->get('login')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 px-50 py-2  focus:ring-[#15406A] focus:border-[#15406A] rounded-full border-gray-300" type="password"
                    name="password" required autocomplete="current-password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex justify-between items-center px-50 mt-6 text-sm">
                <label for="remember_me" class="flex p-2 items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-[#15406A] shadow-sm focus:ring-[#15406A]" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                <a class="text-sm text-[#15406A] font-semibold hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 w-full flex justify-end">
                <x-primary-button
                    class="w-auto bg-[#15406A] text-white font-bold py-2 rounded-full hover:opacity-80 transition">
                    {{ __('LOG IN') }}
                </x-primary-button>
            </div>

    </div>
    </form>
</x-guest-layout>

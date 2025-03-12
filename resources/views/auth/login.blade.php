<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative w-full">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                    autocomplete="current-password" />
                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10 3C5.5 3 2 6.8 1 10c1 3.2 4.5 7 9 7s8-3.8 9-7c-1-3.2-4.5-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}

            {{-- back '/' --}}
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ url('/') }}">
                {{ __('Kembali ke Home') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML =
                    '<path d="M10 3C5.5 3 2 6.8 1 10c1 3.2 4.5 7 9 7s8-3.8 9-7c-1-3.2-4.5-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm-3-5a3 3 0 116 0 3 3 0 01-6 0zM10 5c1.7 0 3.2 1 4 2.5L13 9c-0.6-1-1.8-1.7-3-1.7s-2.4 0.7-3 1.7l-1-1.5C6.8 6 8.3 5 10 5z" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML =
                    '<path d="M10 3C5.5 3 2 6.8 1 10c1 3.2 4.5 7 9 7s8-3.8 9-7c-1-3.2-4.5-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />';
            }
        }
    </script>
</x-guest-layout>

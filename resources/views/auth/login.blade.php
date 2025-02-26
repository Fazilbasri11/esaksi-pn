<x-auth-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="w-full min-h-screen flex items-center justify-center bg-green-900">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            
            <h2 class="text-center text-2xl font-bold text-green-800 brightness-75">E Saksi</h2>

            <div class="flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24">
                    <path fill="green" d="M12 3c-1.27 0-2.4.8-2.82 2H3v2h1.95L2 14c-.47 2 1 3 3.5 3s4.06-1 3.5-3L6.05 7h3.12c.33.85.98 1.5 1.83 1.83V20H2v2h20v-2h-9V8.82c.85-.32 1.5-.97 1.82-1.82h3.13L15 14c-.47 2 1 3 3.5 3s4.06-1 3.5-3l-2.95-7H21V5h-6.17C14.4 3.8 13.27 3 12 3m0 2a1 1 0 0 1 1 1a1 1 0 0 1-1 1a1 1 0 0 1-1-1a1 1 0 0 1 1-1m-6.5 5.25L7 14H4zm13 0L20 14h-3z"/>
                </svg>
            </div>



            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-green-800 font-semibold" />
                    <x-text-input id="email" class="block mt-1 w-full border-green-600 focus:ring-green-500 focus:border-green-500" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-green-800 font-semibold" />
                    <x-text-input id="password" class="block mt-1 w-full border-green-600 focus:ring-green-500 focus:border-green-500"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-green-500 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                        <span class="ms-2 text-sm text-green-700">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-green-700 hover:text-green-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="bg-green-700 hover:bg-green-800 text-white font-bold px-4 py-2 rounded-lg">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </section>
</x-auth-layout>

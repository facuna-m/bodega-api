<x-guest-layout>

    <div class="mb-6 text-center">
        <h1 class='text-3xl font-bold'>Iniciar Sesión</h1>
        <p class='text-slate-800 text-sm'>Ingresa tus credenciales para acceder a Bodega, o crea una cuenta.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-900">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-3">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center border-t border-gray-100 pt-4">
        <p class="text-sm text-gray600">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition">
                Registrate aquí
            </a> 
        </p>
    </div>

</x-guest-layout>

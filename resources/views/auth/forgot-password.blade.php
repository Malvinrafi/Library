<x-guest-layout>
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md animate-slide-down">
        <h1 class="text-2xl font-semibold text-center mb-6">Forgot Password</h1>

        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus class="w-full" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 text-sm">
                have an account? Sign in here
            </a>
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 transition duration-200">
                Send Password Reset Link
            </button>
        </form>
    </div>
</x-guest-layout>

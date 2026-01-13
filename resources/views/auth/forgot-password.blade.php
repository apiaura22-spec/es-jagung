<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-yellow-50 px-4">
        <div class="bg-white shadow-lg rounded-lg max-w-md w-full p-6 sm:p-8">
            
            <!-- Logo atau Judul -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/esjagung_logo.png') }}" alt="Logo Es Jagung" class="w-20 mx-auto">
                <h2 class="text-2xl font-bold text-yellow-600 mt-4">Lupa Password?</h2>
                <p class="text-gray-600 text-sm mt-2">
                    Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form Reset Password -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500"
                        required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Tombol Kirim -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-6">
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-600 hover:underline hover:text-yellow-600">
                        ← Kembali ke Login
                    </a>

                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Kirim Link Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-yellow-50">
        
        <div class="w-full max-w-md mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border-t-8 border-orange-500">
            <div class="text-center p-8 bg-gradient-to-b from-yellow-100 to-white">
                <div class="inline-block p-4 rounded-full bg-orange-100 mb-4">
                    <span class="text-5xl">🌽</span>
                </div>
                <h2 class="text-3xl font-extrabold text-orange-600 tracking-tight">Es Jagung <span class="text-yellow-500">Manis</span></h2>
                <p class="text-gray-500 mt-2 font-medium">Segarnya sampai ke hati! Yuk, pesan sekarang.</p>
            </div>

            <div class="px-8 pb-8">
                {{-- Flash message sukses registrasi --}}
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                        <p class="text-sm font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 ml-1">Alamat Email</label>
                        <div class="relative mt-1">
                            <x-text-input id="email" 
                                class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm pl-10" 
                                type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 ml-1">Password</label>
                        <div class="relative mt-1">
                            <x-text-input id="password" 
                                class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm pl-10" 
                                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500 w-4 h-4"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-orange-500 hover:text-orange-700 font-medium transition"
                               href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-400 via-orange-500 to-yellow-500 hover:from-orange-500 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform transition hover:-translate-y-0.5 active:scale-95 flex justify-center items-center space-x-2">
                            <span>MASUK SEKARANG</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </button>
                    </div>

                    <div class="relative flex py-3 items-center">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase tracking-widest">Atau</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <p class="text-sm text-gray-600 text-center">
                        Baru pertama kali pesan? 
                        <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-800 font-bold underline decoration-yellow-400 decoration-2">
                            Daftar Akun
                        </a>
                    </p>
                </form>
            </div>
        </div>

        <p class="mt-8 text-gray-400 text-xs">
            &copy; {{ date('Y') }} Es Jagung Manis Viral. All rights reserved.
        </p>
    </div>
</x-guest-layout>
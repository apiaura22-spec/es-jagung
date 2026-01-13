<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="flex justify-center -mb-12 relative z-10">
            <div class="bg-white p-4 rounded-full shadow-xl border-4 border-yellow-400">
                <span class="text-5xl animate-bounce block">🌽</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-b-8 border-orange-500 pt-12">
            <div class="text-center p-8 bg-gradient-to-b from-yellow-50 to-white">
                <h2 class="text-2xl font-black text-orange-600 uppercase tracking-widest">
                    Gabung <span class="text-yellow-500">Member</span>
                </h2>
                <p class="text-gray-500 text-sm mt-1 font-medium">Dapatkan promo eksklusif Es Jagung!</p>
            </div>

            <div class="px-8 pb-10">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-sm text-sm">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-orange-700 font-bold ml-1" />
                        <x-text-input id="name" class="block mt-1 w-full bg-yellow-50 border-none focus:ring-2 focus:ring-orange-500 rounded-2xl p-4 shadow-sm" 
                            type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Budi Santoso" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-orange-700 font-bold ml-1" />
                        <x-text-input id="email" class="block mt-1 w-full bg-yellow-50 border-none focus:ring-2 focus:ring-orange-500 rounded-2xl p-4 shadow-sm" 
                            type="email" name="email" :value="old('email')" required placeholder="email@kamu.com" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Nomor WhatsApp')" class="text-orange-700 font-bold ml-1" />
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-bold">
                                +62
                            </span>
                            <x-text-input id="phone" class="block w-full bg-yellow-50 border-none focus:ring-2 focus:ring-orange-500 rounded-2xl p-4 pl-14 shadow-sm" 
                                type="text" name="phone" :value="old('phone')" required placeholder="8123456xxx" />
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 ml-1">*Pastikan nomor aktif untuk info pesanan.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-orange-700 font-bold ml-1 text-sm" />
                            <x-text-input id="password" class="block mt-1 w-full bg-yellow-50 border-none focus:ring-2 focus:ring-orange-500 rounded-2xl p-4 shadow-sm" 
                                type="password" name="password" required />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-orange-700 font-bold ml-1 text-sm" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-yellow-50 border-none focus:ring-2 focus:ring-orange-500 rounded-2xl p-4 shadow-sm" 
                                type="password" name="password_confirmation" required />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all active:scale-95 uppercase tracking-wider">
                            Daftar Sekarang 🌽
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-orange-600 font-extrabold hover:text-yellow-500 underline decoration-yellow-400 decoration-2">Masuk Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
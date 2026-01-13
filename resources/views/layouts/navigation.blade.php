<nav x-data="{ open: false }" class="bg-yellow-200 border-b-2 border-orange-300 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-10 w-auto" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-6 sm:flex sm:ml-10">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
                    class="text-orange-800 hover:text-yellow-900 font-semibold">
                    {{ __('') }}
                </x-nav-link>

                @guest
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')" 
                        class="text-orange-800 hover:text-yellow-900 font-semibold">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')" 
                        class="text-orange-800 hover:text-yellow-900 font-semibold">
                        {{ __('Register') }}
                    </x-nav-link>
                @endguest

                @auth
                    @if(Auth::user()->is_admin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" 
                            class="text-orange-800 hover:text-yellow-900 font-semibold">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')" 
                            class="text-orange-800 hover:text-yellow-900 font-semibold">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>

            <!-- Logout / User Menu -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" 
                        onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="text-orange-800 hover:text-yellow-900 font-semibold">
                        {{ __('Logout') }}
                    </x-dropdown-link>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>

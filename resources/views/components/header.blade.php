<header class="flex items-center justify-between px-6 py-2 bg-white border-b-4 border-orange-600">
    <div class="flex items-center justify-center bg-white">
        <div class="flex items-center w-16 md:w-32">
            <a href="{{ route('dashboard') }}">
                <img src="/storage/servicio.svg" alt="" class="w-32 h-auto">
            </a>
        </div>
        <button @click="sidebarOpen = true" class="ml-1 text-gray-500 lg:ml-5 focus:outline-none">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
        </button>

        <x-links href="{{ route('events') }}" :active="request()->routeIs('events')" title="Calendar"><i class="text-md bx bx-calendar-event"></i></x-links>
        <x-links href="{{ route('gastos') }}" :active="request()->routeIs('gastos')" title="Report"><i class="text-md bx bxs-dashboard"></i></x-links>
        <x-links href="{{ route('balances.index') }}" :active="request()->routeIs('balances.index')" title="Balance"><i class="text-md bx bx-repost"></i></x-links>
        <livewire:add-new-event />
    </div>

    <div class="items-stretch block md:flex">
        <!-- Profile Menu DT -->
        <div class="flex ml-3 md:ml-4">
            <livewire:notification-header />

            <!-- Profile dropdown -->
            <div class="relative p-0 text-sm text-gray-600 cursor-pointer md:px-1 hover:text-gray-800" x-data="{open: false}">
                <div class="flex items-center min-h-full" @click="open = !open">

                    @if(Auth::check())
                        <div class="flex flex-col ml-1">
                            <i class="text-2xl bx bx-user-circle"></i>
                        </div>
                    @endif

                    {{-- <div class="flex items-center max-w-xs text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full"
                            src="https://assets.codepen.io/3321250/internal/avatars/users/default.png?fit=crop&format=auto&height=512&version=1646800353&width=512"
                            alt="">
                    </div> --}}
                </div>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 z-10 py-1 mt-0 origin-top-right bg-white shadow min-w-[400%] rounded-b-md ring-1 ring-black ring-opacity-5 focus:outline-none"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95" role="menu"
                    aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem" tabindex="-1" id="user-menu-item-0">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-jet-dropdown-link>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- <div class="items-center block text-right md:flex">
        @if(Auth::check())
            <div class="relative p-0 text-sm md:mr-2">
                <a class="text-blue-500 hover:underline hover:text-blue-800" href="{{ route('profile.show') }}">{{ strtok(Auth::user()->name, ' ') }}</a>
            </div>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a
                class="text-blue-500 hover:underline hover:text-blue-800"
                href="{{ route('logout') }}"
                onclick="event.preventDefault();
                        this.closest('form').submit();"
                >
                <i class="text-lg text-blue-800 bx bx-log-out"></i>
            </a>
        </form>
    </div> --}}

</header>

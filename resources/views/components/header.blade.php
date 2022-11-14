<header class="flex items-center justify-between px-6 py-2 bg-white border-b-4 border-orange-600">
    <div class="flex items-center justify-center bg-white">
        <div class="flex items-center w-16">
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

    <div class="items-center block md:flex">
        @if(Auth::check())
            <div class="relative p-0 text-sm md:mr-2">
                <a class="text-blue-500 hover:underline hover:text-blue-800" href="{{ route('profile.show') }}">{{ Auth::user()->name }}</a>
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
    </div>

</header>

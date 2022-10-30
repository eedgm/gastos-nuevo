<header class="flex items-center justify-between px-6 py-2 bg-white border-b-4 border-orange-600">
    <div class="flex items-center justify-center bg-white">
        <div class="flex items-center ">
            <a href="{{ route('dashboard') }}">
                <img src="/storage/servicio.svg" alt="" class="w-32 h-auto">
            </a>
        </div>
        <button @click="sidebarOpen = true" class="ml-5 text-gray-500 focus:outline-none">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>

    <div class="flex items-center">
        @if(Auth::check())
            <div class="relative text-sm">
                <a class="text-blue-500 hover:underline hover:text-blue-800" href="{{ route('profile.show') }}">{{ Auth::user()->name }}</a>
            </div>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-jet-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">
                <i class="text-lg text-blue-800 bx bx-log-out"></i>
            </x-jet-dropdown-link>
        </form>
    </div>

</header>

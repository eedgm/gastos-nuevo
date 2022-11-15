<div class="relative flex items-center justify-center m-0 md:mr-4" x-data="{ openNotification: false }">
    <div class="block p-1 text-gray-600 rounded-full hover:text-gray-800">
        <i class="mt-1 text-2xl bx bxs-bell {{ $events->count() > 0 ? 'text-red-500 bx-tada' : ' ' }}" @click="openNotification = !openNotification"></i>
    </div>

    <div x-show="openNotification" @click.away="openNotification = false"
        class="absolute right-0 top-0 z-10 py-1 px-3 mt-11 md:mt-11 origin-top-right bg-white shadow min-w-[1000%] md:min-w-[1500%] rounded-b-md ring-1 ring-black ring-opacity-5 focus:outline-none"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" role="menu"
        aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            @foreach ($events as $event)
                <div class="py-1 border-b border-gray-100 cursor-pointer hover:bg-gray-100">
                    <span class="block text-xs font-black text-blue-600 uppercase">{{ $event->date->format('M d') }}</span>
                    <span>{{ $event->description }}</span>
                    <span
                        class="px-2 py-1 text-xs bg-gray-200 rounded shadow-lg right-5"
                        >
                        {{ $event->cluster->name }}
                    </span>
                    <span
                        class="px-2 py-1 ml-2 text-xs rounded shadow-lg bg-cyan-200 right-5"
                        >
                        {{ $event->account->name }}
                    </span>
                </div>
            @endforeach
            {{-- <hr>
            <div class="my-1 text-center">
                <a class="font-bold hover:text-blue-800" href="{{ route('events.list') }}">Ver todos</a>
            </div> --}}

    </div>
</div>

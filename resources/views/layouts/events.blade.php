<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') {{ config('app.name', 'Gastos') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

        <!-- Icons -->
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

        <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        {{-- <script type="module">
            import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
        </script> --}}

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50"></div>

                <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 overflow-y-auto transition duration-300 transform bg-gray-900 w-50">
                    <div class="flex items-center justify-center bg-white">
                        <div class="flex items-center p-2">
                            <a href="{{ route('events') }}">
                                Gastos
                            </a>

                            {{-- <span class="mx-2 text-2xl font-semibold text-white">SSL</span> --}}
                        </div>
                    </div>

                    <x-sidebarmenu></x-sidebarmenu>
                </div>
                <div class="flex flex-col flex-1 overflow-hidden">
                    {{-- @livewire('navigation-menu') --}}

                    <x-header></x-header>

                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                        <div class="container px-6 py-8 mx-auto">
                            <!-- Page Heading -->
                            @if (isset($header))
                                <h3 class="text-3xl font-medium text-gray-700">{{ $header }}</h3>
                            @endif

                            @yield('content')
                    </main>
                </div>
            </div>
        </div>

        <footer>
            <x-footer></x-footer>
        </footer>

        @stack('modals')

        @livewireScripts

        {{-- <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script> --}}

        @stack('scripts')

        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

        <script>
            const notyf = new Notyf({dismissible: true})
            // notyf.success('hello')
            // notyf.error('hello')
        </script>

    </body>
</html>


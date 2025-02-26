<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- KAI ADMIN START -->
        <link
        rel="icon"
        href="assets/img/kaiadmin/favicon.ico"
        type="image/x-icon"
        />

        <!-- Fonts and icons -->
        <script src="assets/js/plugin/webfont/webfont.min.js"></script>
        <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["assets/css/fonts.min.css"],
            },
            active: function () {
            sessionStorage.fonts = true;
            },
        });
        </script>

        <!-- CSS Files -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/plugins.min.css" />
        <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link rel="stylesheet" href="assets/css/demo.css" />
        <!-- KAI ADMIN END -->
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    
    <div class="min-h-screen flex flex-col">
        {{-- Navigasi Atas --}}
        @include('layouts.navigation')

        <div class="flex flex-1">
            {{-- Sidebar --}}
            <aside class="w-64 bg-white shadow-md h-screen p-4">
                <ul class="space-y-2">
                    <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a></li>
                    <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a></li>
                    <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Settings</a></li>
                </ul>
            </aside>

            {{-- Konten Utama --}}
            <div class="flex-1 p-6">
                @if (isset($header))
                    <header class="bg-white shadow mb-4">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
    
    </body>
</html>

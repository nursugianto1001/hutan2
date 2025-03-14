<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-primary opacity-0 animate-fadeIn">
    <div class="min-h-screen flex items-center justify-center bg-[#15406A] px-4">
        <div class="flex bg-white shadow-lg rounded-lg overflow-hidden w-full max-w-4xl">

            <!-- Left Side (Form) -->
            <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
                {{ $slot }}
            </div>

            <!-- Right Side (Image & Text) -->
            <div
                class="hidden md:flex md:w-1/2 items-center justify-center bg-[#15406A] text-white p-8"
                style="background-image: url('https://th.bing.com/th/id/OIP.A03w8tnRfG2VlZA4T-x-1QHaE7?rs=1&pid=ImgDetMain'); background-size: cover; background-position: center;">
                <div class="text-white text-center">
                    <img src="{{ Vite::asset('resources/image/logo-sibuk.png') }}" alt="Logo" class="w-50 h-50 mx-auto mb-4">
                    <h2 class="text-3xl font-bold">Selamat datang di Sistem Informasi Bursa Kerja</h2>
                    <p class="mt-2">Temukan Karir Impianmu Di sini.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

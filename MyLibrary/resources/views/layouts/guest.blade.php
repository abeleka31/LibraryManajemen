<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan Unhas') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.0/flowbite.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" href="https://www.unhas.ac.id/wp-content/uploads/2024/02/Logo-Resmi-Unhas-1.png" type="image/png">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-white to-gray-200">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full flex justify-center">
            <a href="{{ url('/') }}">
                <img src="https://www.unhas.ac.id/wp-content/uploads/2024/02/Logo-Resmi-Unhas-1.png" alt="Library Logo" class="w-full max-w-xs sm:max-w-md h-auto">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-lg rounded-lg">
            {{ $slot }}
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.0/flowbite.min.js"></script>
</body>
</html>

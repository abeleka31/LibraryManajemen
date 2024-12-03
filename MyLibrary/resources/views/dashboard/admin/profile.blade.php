<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="flex items-center mb-4">
            <img src="https://via.placeholder.com/100" alt="Avatar" class="w-16 h-16 rounded-full shadow-lg">
            <div class="ml-4">
                <h1 class="text-2xl font-bold text-gray-800">Profil             </h1>
                <p class="text-gray-500">{{ $user->role }}</p>
            </div>
        </div>
        <div class="border-t border-gray-200 mt-4"></div>
        <div class="mt-4 space-y-2">
            <p class="text-gray-700"><span class="font-semibold">Nama:</span> {{ $user->name }}</p>
            <p class="text-gray-700"><span class="font-semibold">Email:</span> {{ $user->email }}</p>
            <p class="text-gray-700"><span class="font-semibold">Tanggal Bergabung:</span> {{ $user->created_at->format('d M Y') }}</p>
        </div>
        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Landing Page</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 w-full z-50 shadow-md  bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600" >
        <div class="bg-slate-200  max-w-screen-xl mx-auto px-2 py-4 flex justify-between items-baseline">
            <!-- Logo -->
            <a href="#" class="text-2xl font-bold text-white hover:text-blue-400 transition duration-300">Library</a>

            <!-- Navbar Links -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('dashboard.mahasiswa.myLibrary') }}" class="text-white hover:text-blue-400 transition duration-300">Home</a>
                <a href="{{ route('dashboard.mahasiswa.home') }}" class="text-white hover:text-blue-400 transition duration-300">My Library</a>
                <a href="#services" class="text-white hover:text-blue-400 transition duration-300">Services</a>
                <a href="{{ route('dashboard.mahasiswa.index') }}" class="text-white hover:text-blue-400 transition duration-300">List Book</a>

                @if (Auth::check())
                    <!-- Bell Icon -->
                    <button class="relative">
                        <i class="fas fa-bell text-white text-lg hover:text-blue-400"></i>
                        <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="userDropdownButton" class="flex items-center focus:outline-none">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-500">
                                @if (Auth::user()->image)
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://via.placeholder.com/150?text=No+Image" alt="Gambar Tidak Tersedia" class="w-full h-full object-cover">
                                @endif
                            </div>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg hidden">
                            <a href="{{route('mahasiswa.profile')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{route('loan.listLoan')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Loan</a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-400">Login</a>
                        <a href="{{ route('register') }}" class="text-white hover:text-blue-400">Register</a>
                    </div>
                @endif
            </div>

            <!-- Mobile Navbar Toggle -->
            <button id="mobile-nav-toggle" class="md:hidden text-white p-2 rounded-md hover:bg-gray-700 transition duration-300">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-nav" class="md:hidden fixed inset-0 bg-gray-800 bg-opacity-90 hidden">
        <div class="flex justify-end p-4">
            <button id="close-mobile-nav" class="text-white p-2">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex flex-col items-center space-y-4">
            <a href="{{ route('dashboard.mahasiswa.myLibrary') }}" class="text-white py-2 px-4 hover:bg-gray-700 transition duration-300">Home</a>
            <a href="{{ route('dashboard.mahasiswa.home') }}" class="text-white py-2 px-4 hover:bg-gray-700 transition duration-300">My Library</a>
            <a href="#services" class="text-white py-2 px-4 hover:bg-gray-700 transition duration-300">Services</a>
            <a href="{{ route('dashboard.mahasiswa.index') }}" class="text-white py-2 px-4 hover:bg-gray-700 transition duration-300">List Book</a>
            @if (Auth::check())
                <form action="{{ route('logout') }}" method="POST" class="py-2">
                    @csrf
                    <button type="submit" class="text-white">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white py-2 px-4 hover:bg-gray-700 transition duration-300">Login</a>
                <a href="{{ route('register') }}" class="text-white py-2 px-4 hover:bg-gray-700 transition duration-300">Register</a>
            @endif
        </div>
    </div>

    <!-- Main content area -->
    <div class="pt-18 pb-20 " style="background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6">
        <div class="max-w-screen-xl mx-auto text-center">
            <p>&copy; 2024 Library. All rights reserved.</p>
        </div>
    </footer>

    <!-- Custom JS -->
    <script>
        // Mobile Navbar Toggle
        document.getElementById('mobile-nav-toggle').addEventListener('click', function() {
            document.getElementById('mobile-nav').classList.remove('hidden');
        });
        document.getElementById('close-mobile-nav').addEventListener('click', function() {
            document.getElementById('mobile-nav').classList.add('hidden');
        });

        // User Dropdown Toggle
        const userDropdownButton = document.getElementById('userDropdownButton');
        const userDropdown = document.getElementById('userDropdown');

        userDropdownButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!userDropdownButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

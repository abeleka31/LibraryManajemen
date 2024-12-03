<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard')</title>

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-100">

    <!-- Hamburger Icon (Floating) -->
    <div id="hamburger-icon" class="hamburger sm:hidden fixed top-4 left-4 z-50 cursor-pointer">
        <i class="fas fa-bars text-3xl text-gray-800"></i>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-800 text-white transform -translate-x-full sm:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <div class="flex items-center text-white py-6 px-3">
                <h1 class="text-3xl font-semibold">Library 📖</h1>
            </div>
            <ul class="space-y-2 font-medium">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.home') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt w-6 h-6"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <!-- Profile Dropdown -->
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-200 rounded-lg group hover:bg-gray-700"
                        aria-controls="dropdown-profile" data-collapse-toggle="dropdown-profile">
                        <i class="fas fa-user-circle w-6 h-6"></i>
                        <span class="flex-1 ms-3 text-left">Profile</span>
                    </button>
                    <ul id="dropdown-profile" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('admin.profile') }}" class="flex items-center p-2 text-gray-200 hover:bg-gray-700 pl-11">
                                <i class="fas fa-user w-5 h-5 mr-2"></i>
                                <span>{{ $adminName ?? 'Admin' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-200 hover:bg-gray-700 pl-11" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt w-5 h-5 mr-2"></i>
                                LogOut
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                <!-- Books Dropdown -->
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-200 rounded-lg group hover:bg-gray-700"
                        aria-controls="dropdown-books" data-collapse-toggle="dropdown-books">
                        <i class="fas fa-book w-6 h-6"></i>
                        <span class="flex-1 ms-3 text-left">Books</span>
                    </button>
                    <ul id="dropdown-books" class="hidden py-2 space-y-2">
                        <li><a href="{{ route('books.index') }}" class="flex items-center w-full p-2 pl-11 text-gray-200 hover:bg-gray-700"><i class="fas fa-list mr-2 w-5 h-5"></i>All List</a></li>
                        <li><a href="{{ route('category.index') }}" class="flex items-center w-full p-2 pl-11 text-gray-200 hover:bg-gray-700"><i class="fas fa-th-large mr-2 w-5 h-5"></i>Categories</a></li>
                        <li><a href="{{ route('subCategory.index') }}" class="flex items-center w-full p-2 pl-11 text-gray-200 hover:bg-gray-700"><i class="fas fa-sitemap mr-2 w-5 h-5"></i>Subcategories</a></li>
                    </ul>
                </li>

                <!-- Admin -->
                <li>
                    <a href="{{ route('admin.crud') }}" class="flex items-center p-2 text-gray-200 rounded-lg hover:bg-gray-700">
                        <i class="fas fa-cogs w-6 h-6"></i>
                        <span class="ms-3">Admin</span>
                    </a>
                </li>

                <!-- Staff -->
                <li>
                    <a href="{{ route('admin.daftarStaff') }}" class="flex items-center p-2 text-gray-200 rounded-lg hover:bg-gray-700">
                        <i class="fas fa-users w-6 h-6"></i>
                        <span class="ms-3">Staff</span>
                    </a>
                </li>

                <!-- Student -->
                <li>
                    <a href="{{route('admin.daftarMahasiswa')}}" class="flex items-center p-2 text-gray-200 rounded-lg hover:bg-gray-700">
                        <i class="fas fa-graduation-cap w-6 h-6"></i>
                        <span class="ms-3">Student</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="p-4 sm:ml-64 bg-gray-100 min-h-screen">
        @yield('content')
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <!-- Initialize Hamburger Icon & Sidebar Toggle -->
    <script>
        document.getElementById('hamburger-icon').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full'); // Toggle sidebar visibility
        });
    </script>

    <!-- Include Custom JS -->
    @stack('scripts')
</body>

</html>

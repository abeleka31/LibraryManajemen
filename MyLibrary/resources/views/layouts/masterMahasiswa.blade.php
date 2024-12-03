<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
  <!-- Flowbite CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body >

  <!-- Navbar -->
  <nav class="fixed top-0 z-50 w-full bg-transparent backdrop-blur-lg">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <!-- Logo and Sidebar Toggle -->
        <div class="flex items-center justify-start text-3xl font-bold">
          📚 Librar
        </div>

        <!-- Date, Time, and Profile -->
        <div class="flex items-center space-x-6">

          <!-- Date -->
          <div class="flex items-center text-gray-600 dark:text-gray-300" id="current-date">
            <!-- Calendar Icon -->
            <h2>📆</h2>
            <span id="date-text" class="font-medium text-lg text-gray-800 dark:text-white"></span>
          </div>

          <!-- Time -->
          <div class="flex items-center text-gray-600 dark:text-gray-300" id="current-time">
            <!-- Clock Icon -->
            <h1>⏰</h1>
            <span id="time-text" class="font-medium text-lg text-gray-800 dark:text-white"></span>
          </div>

          <!-- Profile -->
          <div class="flex items-center">
            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
              <span class="sr-only">Open user menu</span>
              <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-transparent">
    <div class="h-full px-3 pb-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
        <li>
          <a href="{{route('dashboard.mahasiswa.home')}}" class="flex items-center justify-center p-3 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 gap-3">
            <i class="fa-solid fa-house text-xl"></i>
            <h1 class="ml-2 text-lg">Beranda</h1>
          </a>
        </li>
        <li>
          <a href="{{route('dashboard.mahasiswa.index')}}" class="flex items-center justify-center p-3 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 gap-3">
            <i class="fa-solid fa-magnifying-glass text-xl"></i>
            <h1 class="ml-2 text-lg">Cari</h1>
          </a>
        </li>
        <li>
          <a href="{{route('loan.listLoan')}}" class="flex items-center justify-center p-3 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 gap-3">
            <i class="fa-solid fa-layer-group text-xl"></i>
            <h1 class="ml-2 text-lg">My Shelf</h1>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="p-4 sm:ml-64 bg-transparent dark:bg-gray-900 backdrop-blur-lg">
    @yield('content') <!-- Konten utama yang akan disertakan -->
  </main>

  <!-- Flowbite JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

  <!-- Date and Time Script -->
  <script>
    function updateDateTime() {
      const date = new Date();
      const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      const weekdayName = weekdays[date.getDay()];
      const dayNumber = date.getDate();
      const monthNumber = date.getMonth() + 1;
      const year = date.getFullYear();
      const formattedDate = `${weekdayName}, ${dayNumber.toString().padStart(2, '0')}-${monthNumber.toString().padStart(2, '0')}-${year}`;
      document.getElementById('date-text').textContent = formattedDate;

      const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
      const formattedTime = date.toLocaleTimeString('en-US', timeOptions);
      document.getElementById('time-text').textContent = formattedTime;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
  </script>

</body>
</html>

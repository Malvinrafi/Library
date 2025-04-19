<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Libreria</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden relative">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 text-white shadow-lg transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out">
            <div class="p-4 font-bold text-xl">Dash Library</div>
            <div class="p-4">
                <div class="text-xs text-gray-400 mb-2">LAYOUTS & PAGES</div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-2 bg-gray-800 rounded-md">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.books.books1') }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-800 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-file mr-3 text-gray-400"></i>
                                <span>Books</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.admin.borrowed_requests') }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-800 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-file mr-3 text-gray-400"></i>
                                <span>Borrowed Books</span>
                            </div>
                        </a>                        
                    </li>
                    <li>
                        <a href="{{ route('dashboard.reports') }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-800 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-file mr-3 text-gray-400"></i>
                                <span>Reports</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Overlay untuk mobile -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden relative z-10">
            <!-- Header -->
            <header class="bg-gray-900 p-4 shadow-sm text-white flex items-center justify-between">
                <!-- Hamburger -->
                <button id="toggleSidebar" class="text-white focus:outline-none md:hidden z-50 relative">
                    <i class="fas fa-bars" id="hamburgerIcon"></i>
                </button>

                <div class="flex items-center space-x-4 ml-auto">
                    <div class="text-sm font-medium text-white hidden sm:block">
                        {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-md">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const hamburgerIcon = document.getElementById('hamburgerIcon');

            toggleBtn.addEventListener('click', function () {
                const isOpen = sidebar.classList.contains('-translate-x-full');
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');

                // Ganti icon dari hamburger ke close (X)
                hamburgerIcon.classList.toggle('fa-bars');
                hamburgerIcon.classList.toggle('fa-times');
            });

            overlay.addEventListener('click', function () {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                hamburgerIcon.classList.remove('fa-times');
                hamburgerIcon.classList.add('fa-bars');
            });
        });
    </script>
</body>
</html>

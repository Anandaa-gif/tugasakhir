<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/smp3.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        secondary: {
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .transition-slow {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-shadow {
            box-shadow: 4px 0 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50" x-data="{ isSidebarOpen: false }">

    @php
        $isKoleksiOpen =
            request()->routeIs('buku.*') ||
            request()->routeIs('kategori.*') ||
            request()->routeIs('jenis.*') ||
            request()->routeIs('penerbit.*');
    @endphp

    <!-- Backdrop untuk sidebar mobile -->
    <div x-show="isSidebarOpen" x-transition.opacity @click="isSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" x-cloak>
    </div>

    <!-- Sidebar -->
    <aside
        class="w-64 bg-primary-600 text-white fixed inset-y-0 left-0 transform transition-transform duration-200 z-30 sidebar-shadow
        -translate-x-full md:translate-x-0"
        :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }" x-cloak>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6 text-center flex items-center justify-center gap-2">
                <span>Admin Perpustakaan</span>
            </h1>
            <nav class="space-y-2">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary-700 transition-slow 
                    {{ request()->routeIs('dashboard') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('pengunjung.tampil7') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary-700 transition-slow 
                    {{ request()->routeIs('pengunjung.*') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                    <i class="fas fa-user-friends w-5 text-center"></i>
                    <span>Data Pengunjung</span>
                </a>

                <a href="{{ route('dataanggota.tampil1') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary-700 transition-slow 
                    {{ request()->routeIs('dataanggota.*') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                    <i class="fas fa-id-card w-5 text-center"></i>
                    <span>Manajemen Anggota</span>
                </a>

                <div x-data="{ open: {{ $isKoleksiOpen ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-primary-700 transition-slow 
                        {{ $isKoleksiOpen ? 'bg-primary-700 text-white font-semibold' : '' }}">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-database w-5 text-center"></i>
                            <span>Data Master</span>
                        </div>
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-sm"></i>
                    </button>
                    <div x-show="open" x-transition.duration.300ms class="ml-8 mt-2 space-y-2">

                        <a href="{{ route('buku.tampil5') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-primary-700 transition-slow 
                            {{ request()->routeIs('buku.*') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                            <i class="fas fa-book w-5 text-center"></i>
                            <span>Data Buku</span>
                        </a>

                        <a href="{{ route('kategori.tampil4') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-primary-700 transition-slow 
                            {{ request()->routeIs('kategori.*') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                            <i class="fas fa-tags w-5 text-center"></i>
                            <span>Data Kategori</span>
                        </a>

                        <a href="{{ route('jenis.tampil3') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-primary-700 transition-slow 
                            {{ request()->routeIs('jenis.*') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                            <i class="fas fa-layer-group w-5 text-center"></i>
                            <span>Data Jenis</span>
                        </a>

                        <a href="{{ route('penerbit.tampil6') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-primary-700 transition-slow 
                            {{ request()->routeIs('penerbit.*') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                            <i class="fas fa-building w-5 text-center"></i>
                            <span>Data Penerbit</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('peminjaman.tampil9') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary-700 transition-slow 
                    {{ request()->routeIs('peminjaman.tampil9') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                    <i class="fas fa-book-open w-5 text-center"></i>
                    <span>Peminjaman</span>
                </a>

                <a href="{{ route('pengembalian.tampil8') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary-700 transition-slow 
                    {{ request()->routeIs('pengembalian.tampil8') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                    <i class="fas fa-exchange-alt w-5 text-center"></i>
                    <span>Pengembalian</span>
                </a>

                <a href="{{ route('peminjaman.riwayat') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary-700 transition-slow 
                    {{ request()->routeIs('peminjaman.riwayat') ? 'bg-primary-700 text-white font-semibold' : '' }}">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span>Riwayat</span>
                </a>

            </nav>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 md:ml-64 h-screen overflow-auto p-6 transition-all duration-200 ease-in-out bg-gray-50">

        <!-- Tombol Hamburger Mobile -->
        <div class="md:hidden flex justify-between items-center mb-4">
            <button @click="isSidebarOpen = !isSidebarOpen"
                class="text-gray-800 hover:text-blue-600 focus:outline-none text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Topbar -->
        <div class="flex justify-end items-center mb-4">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 text-gray-800 font-semibold hover:text-blue-600 focus:outline-none">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.061l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 text-lg">
                    <a href="{{ route('admin.profil') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 min-h-screen">
            @yield('konten')
        </div>
    </main>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih data...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

</body>

</html>

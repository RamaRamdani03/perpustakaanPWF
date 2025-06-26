{{-- resources/views/anggota/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Anggota</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-dark-brown { background-color: #353333; }
    .bg-brown-hover:hover { background-color: #4a4a4a; }
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-amber-100 font-sans">

  <div class="flex transition-all duration-300 min-h-screen">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-dark-brown text-white min-h-screen p-6 space-y-6 transition-all duration-300">
      <div class="text-center">
        <img src="{{ asset('images/logoperpus.png') }}" alt="Logo Perpus" class="h-20 mx-auto mb-4" />
        <h2 class="text-xl font-bold">{{ auth()->user()->nama }}</h2>
      </div>
      <nav class="space-y-3">
        <a href="{{ url('/anggota/dashboard') }}" class="block px-3 py-2 rounded bg-gray-700">Dashboard</a>
        <a href="{{ route('anggota.pinjam') }}" class="block px-3 py-2 rounded hover:bg-brown-hover">Pinjam Buku</a>
        <a href="{{ route('anggota.riwayat') }}" class="block px-3 py-2 rounded hover:bg-brown-hover">Riwayat Peminjaman</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="flex-1 p-10 transition-all duration-300 relative">

      <!-- Sidebar Toggle -->
      <button onclick="toggleSidebar()" class="absolute top-4 left-4 bg-dark-brown text-white p-2 rounded-md shadow-md z-20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- User Dropdown -->
      <div class="absolute top-4 right-6">
        <div class="relative inline-block text-left">
          <button onclick="toggleDropdown()" class="flex items-center px-4 py-2 bg-brown text-white font-semibold rounded-md hover:opacity-90 shadow">
            {{ auth()->user()->nama }}
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-md z-10">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Header -->
      <div class="relative bg-cover bg-center h-64 rounded-lg mb-8" style="background-image: url('{{ asset('images/perpus-banner.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center px-10 text-white">
          <h1 class="text-3xl font-bold mb-2">Selamat Datang di</h1>
          <h2 class="text-4xl font-extrabold mb-4">Perpustakaan Online</h2>
          <p class="text-lg">Tersedia Berbagai Banyak Buku, Ayo Pilih Buku Favorit Kamu 📚✨</p>
        </div>
      </div>

      <!-- Daftar Buku -->
      <h2 class="text-center text-xl font-semibold mb-4">--- Daftar Buku ---</h2>

      <div class="overflow-x-auto px-2">
        <div class="flex space-x-6 pb-4 snap-x snap-mandatory">
          @foreach($books as $book)
            <div class="flex-shrink-0 w-40 snap-center">
              <img src="{{ asset('storage/covers/' . $book->cover) }}" alt="{{ $book->title }}" class="w-full h-56 object-cover rounded-xl shadow-md">
              <p class="mt-2 text-center text-sm font-medium">{{ $book->title }}</p>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Footer -->
      <div class="mt-10 text-center text-gray-600">
        <hr class="my-4">
        <p>© Perpustakaan Online</p>
      </div>
    </main>
  </div>

  <script>
    let sidebarVisible = true;
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main-content');
      if (sidebarVisible) {
        sidebar.classList.add('-ml-64');
        main.classList.add('ml-0');
      } else {
        sidebar.classList.remove('-ml-64');
        main.classList.remove('ml-0');
      }
      sidebarVisible = !sidebarVisible;
    }

    function toggleDropdown() {
      document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    window.addEventListener('click', function (e) {
      const button = document.querySelector('button[onclick="toggleDropdown()"]');
      const dropdown = document.getElementById('dropdownMenu');
      if (!button.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  </script>

</body>
</html>

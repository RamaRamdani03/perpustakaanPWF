<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Anggota - Perpustakaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="{{ asset('images/favicon.png') }}" />
  <style>
    .bg-dark-brown { background-color: #353333; }
    .bg-brown-hover:hover { background-color: #4a4a4a; }
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-amber-100 font-sans">

<div class="flex transition-all duration-300 min-h-screen">
  <!-- Sidebar -->
  <aside id="sidebar" class="w-64 bg-dark-brown text-white flex flex-col p-6 min-h-screen transition-all duration-300">
    <!-- Profil -->
    <div class="text-center">
      <img src="{{ asset('images/logoperpus.png') }}" alt="Logo Perpus" class="h-20 mx-auto mb-4" />
      <h2 class="text-xl font-bold">{{ auth()->user()->nama }}</h2>
    </div>

    <!-- Navigasi -->
    <nav class="space-y-3 mt-6 flex-grow">
      <a href="{{ url('/anggota/dashboard') }}" class="block px-3 py-2 rounded {{ request()->is('anggota/dashboard') ? 'bg-gray-700' : 'hover:bg-brown-hover' }}">Dashboard</a>
      <a href="{{ route('anggota.pinjam.riwayat') }}" class="block px-3 py-2 rounded {{ request()->routeIs('anggota.pinjam.riwayat') ? 'bg-gray-700' : 'hover:bg-brown-hover' }}">Peminjaman Buku</a>
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-2 rounded text-white font-semibold transition">
        Logout
      </button>
    </form>
  </aside>

  <!-- Main Content -->
  <main id="main-content" class="flex-1 p-10 transition-all duration-300 relative">

    <!-- Sidebar Toggle -->
    <button onclick="toggleSidebar()" class="absolute top-4 left-4 bg-dark-brown text-white p-2 rounded-md shadow-md z-20">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Hero Banner -->
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
  <div class="flex-shrink-0 sm:w-40 w-32 snap-center">
    <div>
      @if($book->cover)
        <img src="data:image/jpeg;base64,{{ base64_encode($book->cover) }}"
             alt="{{ $book->judul_buku }}"
             class="w-full h-56 object-cover rounded-xl shadow-md">
      @else
        <img src="{{ asset('images/default-cover.jpg') }}"
             alt="{{ $book->judul_buku }}"
             class="w-full h-56 object-cover rounded-xl shadow-md">
      @endif
      <p class="mt-2 text-center text-sm font-medium">{{ $book->judul_buku }}</p>
    </div>
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
    sidebar.classList.toggle('-ml-64');
    sidebarVisible = !sidebarVisible;
  }
</script>

</body>
</html>

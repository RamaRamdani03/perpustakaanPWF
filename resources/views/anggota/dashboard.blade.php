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
    .blur-overlay {
      backdrop-filter: blur(8px);
      background-color: rgba(255, 255, 255, 0.4); /* Putih semi-transparan */
    }
  </style>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-white shadow flex justify-between items-center px-6 py-4">
  <div class="flex items-center space-x-2">
    <img src="{{ asset('images/logoperpus.png') }}" alt="Logo" class="h-10">
    <h1 class="text-xl font-bold">Perpustakaan Teras Baca</h1>
  </div>

  <div class="flex items-center space-x-4">
    <a href="{{ route('anggota.pinjam.riwayat') }}" class="text-sm font-medium hover:underline">Pinjam Buku</a>
    
    <!-- Dropdown User -->
    <div class="relative">
      <button onclick="toggleDropdown()" class="flex items-center text-sm font-medium hover:underline">
         {{ auth('anggota')->user()->nama_anggota ?? 'Anggota' }}
        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</header>

<!-- Hero Section dengan Blur Putih Kiri -->
<section class="relative bg-cover bg-center h-64" style="background-image: url('{{ asset('images/perpus.jpg') }}');">
  <div class="absolute inset-0 flex items-end justify-start px-8 pb-6">
    <div class="blur-overlay px-8 py-4 rounded-lg text-gray-800 max-w-md">
      <h2 class="text-2xl font-bold mb-1">Selamat Datang di</h2>
      <h3 class="text-3xl font-extrabold mb-2">Perpustakaan Teras Baca</h3>
      <p class="text-base">Tersedia Berbagai Banyak Buku, Ayo Pilih Buku Favorit Kamu 😊</p>
    </div>
  </div>
</section>

<!-- Daftar Buku Carousel -->
<section class="bg-white py-8">
  <h2 class="text-center text-xl font-semibold mb-6">--- Daftar Buku ---</h2>
  <div class="relative max-w-5xl mx-auto flex items-center">
    
    <!-- Tombol Kiri -->
    <button onclick="scrollLeft()" class="absolute left-0 bg-white p-2 rounded-full shadow hover:bg-gray-100 z-10">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Daftar Buku Scroll -->
    <div id="bookContainer" class="flex overflow-x-auto space-x-6 px-12 pb-4 scrollbar-hide">
      @foreach($books as $book)
      <div class="flex-shrink-0 w-40 text-center">
        @if($book->cover)
          <img src="{{ asset('covers/' . $book->cover) }}" alt="{{ $book->judul_buku }}" class="h-56 object-cover rounded-xl shadow-md">
        @else
          <img src="{{ asset('images/default-cover.jpg') }}" alt="{{ $book->judul_buku }}" class="h-56 object-cover rounded-xl shadow-md">
        @endif
        <p class="mt-2 text-sm font-medium">{{ $book->judul_buku }}</p>
      </div>
      @endforeach
    </div>

    <!-- Tombol Kanan -->
    <button onclick="scrollRight()" class="absolute right-0 bg-white p-2 rounded-full shadow hover:bg-gray-100 z-10">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-100 border-t py-4 text-center text-sm text-gray-600">
  © Perpustakaan Teras baca
</footer>

<script>
  function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
  }

  window.addEventListener('click', function(e) {
    const button = document.querySelector('button[onclick="toggleDropdown()"]');
    const dropdown = document.getElementById('dropdownMenu');
    if (!button.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
    }
  });

  function scrollLeft() {
    document.getElementById('bookContainer').scrollBy({ left: -200, behavior: 'smooth' });
  }
  
  function scrollRight() {
    document.getElementById('bookContainer').scrollBy({ left: 200, behavior: 'smooth' });
  }
</script>

</body>
</html>

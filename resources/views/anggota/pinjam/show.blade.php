<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Detail Peminjaman Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-library {
      background-image: url('{{ asset('images/bg-library.jpg') }}');
      background-size: cover;
      background-position: center;
    }
    .bg-overlay {
      background-color: rgba(255, 255, 255, 0.9);
    }
  </style>
</head>
<body class="bg-library bg-fixed font-sans">

  <div class="min-h-screen bg-overlay flex flex-col">
    <!-- Header -->
    <div class="flex justify-between items-center p-6">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/logoperpus.png') }}" class="h-12" alt="Logo">
        <span class="text-lg font-bold text-gray-800">Perpustakaan Teras Baca</span>
      </div>
      <div class="flex items-center space-x-6">
        <a href="{{ route('anggota.pinjam.form') }}" class="text-gray-900 font-semibold hover:underline">Pinjam Buku</a>
        <div class="relative inline-block text-left">
          <button id="dropdownBtn" onclick="toggleDropdown()" class="text-gray-800 font-semibold flex items-center space-x-1">
            <span>{{ auth()->user()->nama }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    </div>

    <!-- Detail Content -->
    <div class="flex justify-center items-center flex-grow px-4 py-10">
      <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md text-center">
        <!-- Tombol Kembali -->
        <a href="{{ route('anggota.pinjam.index') }}" class="inline-block mb-4 text-blue-600 hover:underline text-sm">
          ← Kembali ke Daftar Pinjaman
        </a>

        <h2 class="text-xl font-semibold mb-6 text-gray-800">Detail Peminjaman</h2>

        <img 
          src="{{ $peminjaman->buku->cover ? asset('storage/covers/' . $peminjaman->buku->cover) : asset('images/default-book.jpg') }}" 
          alt="{{ $peminjaman->buku->judul_buku }}" 
          class="mx-auto mb-6 w-40 h-60 object-cover rounded shadow-md"
        >

        <div class="text-left space-y-2 text-sm text-gray-800">
          <p><strong>Judul Buku:</strong><br>{{ $peminjaman->buku->judul_buku }}</p>
          <p><strong>Penulis:</strong><br>{{ $peminjaman->buku->penulis }}</p>
          <p><strong>Tanggal Peminjaman:</strong><br>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d F Y') }}</p>
          <p><strong>Tanggal Pengembalian:</strong><br>{{ \Carbon\Carbon::parse($peminjaman->batas_kembali)->translatedFormat('d F Y') }}</p>
        </div>

        @if($peminjaman->status_pinjam === 'dipinjam')
          <form action="{{ route('anggota.pinjam.kembalikan', $peminjaman->id_pinjam) }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md">
              Kembalikan Buku
            </button>
          </form>
        @else
          <div class="mt-6 text-green-600 font-semibold">📚 Buku telah dikembalikan.</div>
        @endif
      </div>
    </div>
  </div>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById('dropdownMenu');
      dropdown.classList.toggle('hidden');
    }

    window.addEventListener('click', function (e) {
      const dropdown = document.getElementById('dropdownMenu');
      const button = document.getElementById('dropdownBtn');
      if (!button.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  </script>
</body>
</html>

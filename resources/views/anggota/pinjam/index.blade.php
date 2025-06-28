<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Daftar Pinjaman Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-brown {
      background-color: #5c4033;
    }

    .bg-overlay {
      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('images/perpussantai.jpg') }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
  </style>
</head>

<body class="bg-overlay font-sans min-h-screen">

  <!-- Navbar Atas -->
  <header class="bg-white bg-opacity-90 shadow-md flex items-center justify-between px-6 py-4">
    <div class="flex items-center space-x-3">
      <a href="{{ route('anggota.dashboard') }}">
        <img src="{{ asset('images/logoperpus.png') }}" class="h-10 cursor-pointer" alt="Logo">
      </a>
      <span class="text-lg font-bold">Peminjaman (Anggota)</span>
    </div>

    <nav class="flex items-center space-x-6">
      <a href="{{ route('anggota.pinjam.riwayat') }}" class="text-sm font-medium hover:underline">Pinjam Buku</a>

      <div class="relative">
        <button onclick="toggleDropdown()" class="flex items-center text-sm font-medium hover:underline">
          {{ auth('anggota')->user()->nama_anggota ?? 'Anggota' }}
          <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="dropdownMenu"
          class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-md z-10">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
              class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
          </form>
        </div>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="p-10">
    <div class="flex justify-between items-center mb-8">
      <a href="{{ route('anggota.pinjam.form') }}"
        class="bg-brown text-white px-4 py-2 rounded hover:bg-opacity-90 font-semibold transition">
        + Tambah Peminjaman
      </a>
    </div>

    <h1 class="text-center text-3xl font-bold text-white mb-10">Daftar Pinjaman Buku</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($peminjamans as $pinjam)
      <div class="bg-white p-4 rounded-xl shadow-lg hover:scale-105 transition-transform">

      @if($pinjam->buku->cover)
      <img src="{{ asset('covers/' . $pinjam->buku->cover) }}" alt="{{ $pinjam->buku->judul_buku }}"
      class="h-56 w-auto max-w-full mx-auto object-contain rounded-xl shadow-md">
    @else
      <img src="{{ asset('images/default-cover.jpg') }}" alt="{{ $pinjam->buku->judul_buku }}"
      class="h-56 w-auto max-w-full mx-auto object-contain rounded-xl shadow-md">
    @endif


      <div class="text-sm text-gray-800 space-y-1 mt-4">
        <p><strong>Judul Buku:</strong><br>{{ $pinjam->buku->judul_buku }}</p>
        <p><strong>Penulis:</strong><br>{{ $pinjam->buku->penulis }}</p>
        <p><strong>Tanggal Peminjaman:</strong><br>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('Y-m-d') }}
        </p>
        <p><strong>Tanggal
          Pengembalian:</strong><br>{{ \Carbon\Carbon::parse($pinjam->batas_kembali)->format('Y-m-d') }}</p>
      </div>

      @if ($pinjam->status_pinjam === 'accepted')
      <form action="{{ route('anggota.pinjam.kembalikan', $pinjam->id_pinjam) }}" method="POST" class="mt-4"
      onsubmit="return confirm('Yakin ingin mengembalikan buku ini?');">
      @csrf
      <button type="submit" class="w-full bg-brown text-white py-2 rounded hover:bg-opacity-90 font-semibold">
      Kembalikan
      </button>
      </form>
    @else
      <div class="mt-4 text-center text-sm text-red-600 font-semibold">
      Belum di-accept
      </div>
    @endif
      </div>
    @empty
      <div class="col-span-full text-center text-white py-10">
      <img src="{{ asset('images/empty.png') }}" alt="No data" class="mx-auto w-32 mb-4">
      <p class="text-lg">Belum ada buku yang sedang dipinjam.</p>
      </div>
    @endforelse
    </div>
  </main>

  <script>
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
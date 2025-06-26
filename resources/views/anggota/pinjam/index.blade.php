<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Daftar Pinjaman Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-dark-brown { background-color: #353333; }
    .bg-brown-hover:hover { background-color: #4a4a4a; }
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-library bg-fixed font-sans">

  <div class="min-h-screen bg-overlay flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-brown text-white p-6 space-y-6 flex flex-col">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/logoperpus.png') }}" class="h-10" alt="Logo" />
        <span class="text-xl font-bold">Perpustakaan</span>
      </div>
      <nav class="flex-grow">
        <ul class="space-y-3 text-sm font-medium">
          <li><a href="{{ route('anggota.dashboard') }}" class="block px-3 py-2 hover:bg-black hover:text-brown rounded">Dashboard</a></li>
          <li><a href="{{ route('anggota.pinjam.riwayat') }}" class="block px-3 py-2 bg-black text-brown rounded">Peminjaman Buku</a></li>
        </ul>
      </nav>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block w-full bg-red-600 hover:bg-red-700 py-2 rounded text-center text-white font-semibold">Logout</button>
      </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow p-10">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pinjaman Buku</h1>
        <a href="{{ route('anggota.pinjam.form') }}" class="bg-brown text-white px-4 py-2 rounded hover:bg-opacity-90 font-semibold transition">
          + Tambah Peminjaman
        </a>
      </div>

      <!-- Daftar Buku Dipinjam -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($peminjamans as $pinjam)
          <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition duration-300">
            @if($pinjam->buku->cover)
  <img 
    src="data:image/jpeg;base64,{{ base64_encode($pinjam->buku->cover) }}" 
    alt="{{ $pinjam->buku->judul_buku }}" 
    class="w-full h-56 object-cover rounded mb-4"
  >
@else
  <img 
    src="{{ asset('images/default-book.jpg') }}" 
    alt="Default Cover" 
    class="w-full h-56 object-cover rounded mb-4"
  >
@endif
            <div class="text-sm text-gray-800 space-y-1">
              <p><strong>Judul Buku:</strong><br>{{ $pinjam->buku->judul_buku }}</p>
              <p><strong>Penulis:</strong><br>{{ $pinjam->buku->penulis }}</p>
              <p><strong>Tanggal Peminjaman:</strong><br>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('Y-m-d') }}</p>
              <p><strong>Tanggal Pengembalian:</strong><br>{{ \Carbon\Carbon::parse($pinjam->batas_kembali)->format('Y-m-d') }}</p>
            </div>
            @if ($pinjam->status_pinjam === 'accepted')
  <form action="{{ route('anggota.pinjam.kembalikan', $pinjam->id_pinjam) }}" method="POST" class="mt-4" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?');">
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
          <div class="col-span-full text-center text-gray-500 py-10">
            <img src="{{ asset('images/empty.png') }}" alt="No data" class="mx-auto w-32 mb-4">
            <p class="text-lg">Belum ada buku yang sedang dipinjam.</p>
          </div>
        @endforelse
      </div>
    </main>
  </div>

</body>
</html>

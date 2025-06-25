<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Data Peminjaman</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-dark-brown { background-color: #353333; }
    .bg-brown-hover:hover { background-color: #4a4a4a; }
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-amber-100 font-sans">
  <div class="flex transition-all duration-300">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-dark-brown text-white min-h-screen p-6 space-y-6">
      <div class="text-center">
        <img src="{{ asset('images/logoperpus.png') }}" alt="Logo Perpus" class="h-20 mx-auto mb-4" />
        <h2 class="text-xl font-bold">{{ auth()->user()->nama_pustaka }}</h2>
      </div>
      <nav class="space-y-3">
        <a href="{{ url('/pustakawan/dashboard') }}" class="block px-3 py-2 rounded bg-brown-hover">Dashboard</a>
        <a href="{{ route('buku.index') }}" class="block px-3 py-2 rounded bg-brown-hover">Buku</a>
        <a href="{{ route('anggota.index') }}" class="block px-3 py-2 rounded bg-brown-hover">Anggota</a>
        <a href="{{ route('peminjaman.index') }}" class="block px-3 py-2 rounded bg-gray-700">Peminjaman</a>
        <a href="#" class="block px-3 py-2 rounded hover:bg-brown-hover">Pengembalian</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div id="main-content" class="flex-1 p-10 relative">
      <!-- Page Title -->
      <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-10">Data Peminjaman</h1>

      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto border border-gray-300 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-4 py-2">Nama Anggota</th>
              <th class="border px-4 py-2">Judul Buku</th>
              <th class="border px-4 py-2">Tgl Pinjam</th>
              <th class="border px-4 py-2">Batas Kembali</th>
              <th class="border px-4 py-2">Status</th>
              <th class="border px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($peminjams as $peminjaman)
              <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">{{ $peminjaman->anggota->nama_anggota ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $peminjaman->buku->judul_buku ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $peminjaman->tgl_pinjam }}</td>
                <td class="border px-4 py-2">{{ $peminjaman->batas_kembali }}</td>
                <td class="border px-4 py-2">
                  @if($peminjaman->status_pinjam == 'dipinjam')
                    <form action="{{ route('peminjaman.update', $peminjaman->id_pinjam) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="bg-yellow-400 text-white px-2 py-1 rounded text-xs hover:bg-yellow-500">
                        Tandai Dikembalikan
                      </button>
                    </form>
                  @else
                    <span class="text-green-600 font-semibold">Dikembalikan</span>
                  @endif
                </td>
                <td class="border px-4 py-2 text-center">
                  <form action="{{ route('peminjaman.destroy', $peminjaman->id_pinjam) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-gray-500 py-4">Belum ada data peminjaman.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Data Pengembalian</title>
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
    <aside id="sidebar" class="w-64 bg-dark-brown text-white min-h-screen p-6 space-y-6 transition-all duration-300">
      <div class="text-center">
        <img src="{{ asset('images/logoperpus.png') }}" alt="Logo Perpus" class="h-20 mx-auto mb-4" />
        <h2 class="text-xl font-bold">{{ auth()->user()->nama_pustaka }}</h2>
      </div>
      <nav class="space-y-3">
        <a href="{{ url('/pustakawan/dashboard') }}" class="block px-3 py-2 rounded bg-brown-hover">Dashboard</a>
        <a href="{{ route('buku.index') }}" class="block px-3 py-2 rounded bg-brown-hover">Buku</a>
        <a href="{{ route('anggota.index') }}" class="block px-3 py-2 rounded bg-brown-hover">Anggota</a>
        <a href="{{ route('peminjaman.index') }}" class="block px-3 py-2 rounded bg-brown-hover">Peminjaman</a>
        <a href="{{ route('pengembalian.index') }}" class="block px-3 py-2 rounded bg-gray-700">Pengembalian</a>
        <a href="{{ route('pustakawan.kategori.index') }}" class="block px-3 py-2 rounded hover:bg-brown-hover">Kategori</a>
      </nav>
    </aside>

    <!-- Content -->
    <div id="main-content" class="flex-1 p-10 transition-all duration-300 relative">
      <!-- Sidebar -->
      <button onclick="toggleSidebar()" class="absolute top-4 left-4 bg-dark-brown text-white p-2 rounded-md shadow-md z-20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Dropdown logout -->
      <div class="absolute top-4 right-6">
        <div class="relative inline-block text-left">
          <button onclick="toggleDropdown()" class="flex items-center px-4 py-2 bg-brown text-white font-semibold rounded-md hover:opacity-90 shadow">
            {{ auth()->user()->nama_pustaka ?? 'Pustakawan' }}
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

      <!-- Data Pengambalian -->
      <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-12">Data Pengembalian</h1>

      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto border border-gray-300 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-4 py-2">Nama Anggota</th>
              <th class="border px-4 py-2">Judul Buku</th>
              <th class="border px-4 py-2">Tanggal Kembali</th>
              <th class="border px-4 py-2">Denda</th>
              <th class="border px-4 py-2">Status</th>
              <th class="border px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($peminjams as $peminjam)
              @php
                $tglKembali = $peminjam->updated_at;
                $batas = $peminjam->batas_kembali;
                $denda = $tglKembali->gt($batas) ? $tglKembali->diffInDays($batas) * 1000 : 0;
                $statusKembali = $denda > 0 ? 'terlambat' : 'selesai';
              @endphp
              <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">{{ $peminjam->anggota->nama_anggota ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $peminjam->buku->judul_buku ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $tglKembali->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">Rp{{ number_format($denda, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">
                  @if($peminjam->pengembalian)
                    <span class="{{ $peminjam->pengembalian->status_kembali == 'terlambat' ? 'text-red-600' : 'text-green-600' }} font-semibold">
                      {{ ucfirst($peminjam->pengembalian->status_kembali) }}
                    </span>
                  @else
                    <span class="text-yellow-500 font-semibold">Belum Ditandai</span>
                  @endif
                </td>
                <td class="border px-4 py-2 text-center">
                  @if(!$peminjam->pengembalian)
                    <form action="{{ route('pengembalian.update', $peminjam->id_pinjam) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                        Tandai Selesai
                      </button>
                    </form>
                  @else
                    <span class="text-gray-400 text-xs italic">Sudah Ditandai</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-gray-500 py-4">Belum ada data pengembalian.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    let sidebarVisible = true;
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main-content');
      sidebar.classList.toggle('-ml-64');
      sidebarVisible = !sidebarVisible;
    }

    function toggleDropdown() {
      document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    window.addEventListener('click', function (e) {
      const btn = document.querySelector('button[onclick="toggleDropdown()"]');
      const menu = document.getElementById('dropdownMenu');
      if (!btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
      }
    });
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Data Anggota</title>
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
        <h2 class="text-xl font-bold">
        {{ auth()->user()->nama_pustaka}}
        </h2>
      </div>
      <nav class="space-y-3">
        <a href="{{ url('/pustakawan/dashboard') }}" class="block px-3 py-2 rounded bg-brown-hover">Dashboard</a>
        <a href="{{ route('buku.index') }}" class="block px-3 py-2 rounded hover:bg-brown-hover">Buku</a>
        <a href="{{ route('anggota.index') }}" class="block px-3 py-2 rounded bg-gray-700">Anggota</a>
        <a href="{{ route('peminjaman.index') }}" class="block px-3 py-2 rounded hover:bg-brown-hover">Peminjaman</a>
        <a href="#" class="block px-3 py-2 rounded hover:bg-brown-hover">Pengembalian</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div id="main-content" class="flex-1 p-10 transition-all duration-300 relative">

      <!-- Sidebar Toggle Button -->
      <button onclick="toggleSidebar()" class="absolute top-4 left-4 bg-dark-brown text-white p-2 rounded-md shadow-md z-20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- User Dropdown -->
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

      <!-- Page Title -->
      <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-12">Data Anggota</h1>

      <!-- Button Tambah Anggota -->
      <a href="{{ route('anggota.create') }}"
         class="inline-block bg-brown hover:opacity-90 text-white px-4 py-2 rounded mb-4 shadow">
         + Tambah Anggota
      </a>

      <!-- Tabel Data Anggota -->
      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-auto border border-gray-300 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-6 py-3 text-left font-semibold text-gray-700">Nama</th>
              <th class="border px-6 py-3 text-left font-semibold text-gray-700">Username</th>
              <th class="border px-6 py-3 text-left font-semibold text-gray-700">Telepon</th>
              <th class="border px-6 py-3 text-left font-semibold text-gray-700">Alamat</th>
              <th class="border px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($anggotas as $anggota)
              <tr class="hover:bg-gray-50">
                <td class="border px-6 py-3">{{ $anggota->nama_anggota }}</td>
                <td class="border px-6 py-3">{{ $anggota->username }}</td>
                <td class="border px-6 py-3">{{ $anggota->no_tlp_anggota }}</td>
                <td class="border px-6 py-3">{{ $anggota->alamat_anggota }}</td>
                <td class="border px-6 py-3 text-center space-x-3">
                  <a href="{{ route('anggota.edit', $anggota->id_anggota) }}" class="text-blue-600 hover:underline">Edit</a>
                  <button onclick="openDeleteModal({{ $anggota->id_anggota }})" class="text-red-600 hover:underline">Hapus</button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-gray-500 py-6">Belum ada data anggota.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Modal Konfirmasi Hapus -->
      <div id="deleteModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-80 text-center">
          <h2 class="text-lg font-semibold mb-2 text-gray-800">Konfirmasi Hapus</h2>
          <p class="text-sm text-gray-600 mb-4">Yakin ingin menghapus anggota ini?</p>
          <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center space-x-4">
              <button type="button" onclick="closeDeleteModal()" class="px-4 py-1 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
              <button type="submit" class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
            </div>
          </form>
        </div>
      </div>

    </div>
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

    function openDeleteModal(id) {
      const form = document.getElementById('deleteForm');
      form.action = `/pustakawan/anggota/${id}`; // Sesuaikan dengan route destroy
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }
  </script>

</body>
</html>

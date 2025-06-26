<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Kategori Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-amber-100 font-sans min-h-screen relative">

  <!-- Tombol Kembali di Pojok Kiri Atas -->
  <div class="absolute top-4 left-6 z-20">
    <a href="{{ route('pustakawan.kategori.index') }}" class="flex items-center text-xs text-gray-700 hover:text-gray-900">
      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali
    </a>
  </div>

  <!-- Main Content -->
  <div class="p-6 pt-24 max-w-md mx-auto">
    <h1 class="text-xl font-semibold text-gray-800 mb-5 text-center">Tambah Kategori Buku</h1>

    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
      <form action="{{ route('pustakawan.kategori.store') }}" method="POST" class="space-y-3 text-sm">
        @csrf

        <div>
          <label class="block text-gray-700 font-medium text-xs">Nama Kategori</label>
          <input
            type="text"
            name="nama_kategori"
            class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300"
            required
          />
        </div>

        <!-- Tombol Simpan -->
        <div class="pt-1">
          <button
            type="submit"
            class="w-full bg-brown hover:opacity-90 text-white text-xs px-3 py-1.5 rounded shadow"
          >
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

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

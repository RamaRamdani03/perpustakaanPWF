{{-- resources/views/admin/pustakawan/edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Pustakawan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-amber-100 font-sans min-h-screen relative">

  <!-- Admin Dropdown -->
  <div class="absolute top-4 right-6 z-20">
    <div class="relative inline-block text-left">
      <button onclick="toggleDropdown()" class="flex items-center px-2 py-1 text-xs bg-brown text-white font-medium rounded-md hover:opacity-90 shadow">
        Admin
        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-md z-10">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="block w-full text-left px-3 py-1 text-xs text-gray-700 hover:bg-gray-100">Logout</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Tombol Kembali di Pojok Kiri Atas -->
  <div class="absolute top-4 left-6 z-20">
    <a href="{{ route('pustakawan.index') }}" class="flex items-center text-xs text-gray-700 hover:text-gray-900">
      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali
    </a>
  </div>

  <!-- Main Content -->
  <div class="p-6 pt-24 max-w-md mx-auto">
    <h1 class="text-xl font-semibold text-gray-800 mb-5 text-center">Edit Pustakawan</h1>

    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
      <form action="{{ route('pustakawan.update', $pustakawan->id_pustakawan) }}" method="POST" class="space-y-3 text-sm">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-gray-700 font-medium text-xs">Nama</label>
          <input type="text" name="nama_pustaka" value="{{ old('nama_pustaka', $pustakawan->nama_pustaka) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Username</label>
          <input type="text" name="username" value="{{ old('username', $pustakawan->username) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Password <span class="text-gray-400">(kosongkan jika tidak ingin diubah)</span></label>
          <input type="password" name="password" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" placeholder="Isi jika ingin ganti password">
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Nomor Telepon</label>
          <input type="text" name="no_tlp_pustaka" value="{{ old('no_tlp_pustaka', $pustakawan->no_tlp_pustaka) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Alamat</label>
          <textarea name="alamat_pustaka" rows="2" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>{{ old('alamat_pustaka', $pustakawan->alamat_pustaka) }}</textarea>
        </div>

        <!-- Tombol Simpan -->
        <div class="pt-1">
          <button type="submit" class="w-full bg-brown hover:opacity-90 text-white text-xs px-3 py-1.5 rounded shadow">Update</button>
        </div>
      </form>
    </div>
  </div>

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
  </script>

</body>
</html>

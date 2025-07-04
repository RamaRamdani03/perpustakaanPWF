<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-brown { background-color: #5c4033; }
  </style>
</head>
<body class="bg-amber-100 font-sans min-h-screen relative">

  <!-- User Dropdown -->
  <div class="absolute top-4 right-6 z-20">
    <div class="relative inline-block text-left">
      <button onclick="toggleDropdown()" class="flex items-center px-2 py-1 text-xs bg-brown text-white font-medium rounded-md hover:opacity-90 shadow">
        {{ auth()->user()->nama_pustaka ?? 'Pustakawan' }}
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

  <!-- Tombol Kembali -->
  <div class="absolute top-4 left-6 z-20">
    <a href="{{ route('buku.index') }}" class="flex items-center text-xs text-gray-700 hover:text-gray-900">
      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali
    </a>
  </div>

  <!-- Main Content -->
  <div class="p-6 pt-24 max-w-md mx-auto">
    <h1 class="text-xl font-semibold text-gray-800 mb-5 text-center">Edit Buku</h1>

    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
      <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-gray-700 font-medium text-xs">Judul Buku</label>
          <input type="text" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Kategori</label>
          <select name="id_kategori" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
              <option value="{{ $kategori->id_kategori }}" {{ $kategori->id_kategori == $buku->id_kategori ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Penulis</label>
          <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Penerbit</label>
          <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Tahun Terbit</label>
          <input type="number" name="tahun_terbit" min="1000" max="9999" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300" required>
        </div>

        <!-- ✅ Preview dan Upload Gambar -->
        <div>
          <label class="block text-gray-700 font-medium text-xs">Gambar Saat Ini</label>
          @if($buku->cover)
            <img src="data:image/jpeg;base64,{{ base64_encode($buku->cover) }}" alt="Gambar Buku" class="w-32 h-auto mt-1 mb-2 border rounded">
          @else
            <p class="text-xs text-gray-500 italic">Belum ada gambar</p>
          @endif
        </div>

        <div>
          <label class="block text-gray-700 font-medium text-xs">Ganti Gambar</label>
          <input type="file" name="cover" accept="image/*" class="w-full px-2 py-1 border rounded text-xs focus:outline-none focus:ring-1 focus:ring-amber-300">
        </div>

        <!-- Tombol Update -->
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

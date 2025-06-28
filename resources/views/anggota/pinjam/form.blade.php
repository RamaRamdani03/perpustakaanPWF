<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Peminjaman Buku</title>
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
        <a href="{{ route('anggota.pinjam.riwayat') }}" class="text-gray-900 font-bold hover:text-gray-800">X</a>
      </div>
    </div>

    <!-- Form Section -->
    <div class="flex justify-center items-center flex-grow">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
        <h2 class="text-xl font-semibold mb-6 text-center">Form Peminjaman Buku</h2>

        @if(session('error'))
          <div class="text-red-600 mb-4 text-center font-semibold">
            {{ session('error') }}
          </div>
        @endif

        <form id="formPinjam" method="POST">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-4 col-span-2">

              <!-- Judul Buku -->
              <div>
                <label for="id_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                <select name="id_buku" id="id_buku" class="mt-1 block w-full border-gray-300 rounded" required>
                  <option value="">-- Pilih Judul Buku --</option>
                  @foreach($books as $book)
                    <option 
                      value="{{ $book->id_buku }}" 
                      data-cover="{{ $book->cover ? asset('covers/' . $book->cover) : asset('images/default-cover.jpg') }}"
                      {{ old('id_buku') == $book->id_buku ? 'selected' : '' }}>
                      {{ $book->judul_buku }}
                    </option>
                  @endforeach
                </select>
                @error('id_buku')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Tanggal Pinjam -->
              <div>
                <label class="block text-sm font-medium">Tanggal Peminjaman</label>
                <input type="date" name="tgl_pinjam" class="mt-1 block w-full border-gray-300 rounded" 
                  value="{{ old('tgl_pinjam', now()->toDateString()) }}" required>
                @error('tgl_pinjam')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Tanggal Kembali -->
              <div>
                <label class="block text-sm font-medium">Tanggal Pengembalian</label>
                <input type="date" name="batas_kembali" class="mt-1 block w-full border-gray-300 rounded" 
                  value="{{ old('batas_kembali', now()->addDays(7)->toDateString()) }}" required>
                @error('batas_kembali')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Submit -->
              <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded w-full md:w-auto">
                Pinjam Buku
              </button>
            </div>

            <!-- Cover Preview -->
            <div>
              <img id="coverPreview" src="{{ asset('images/logoperpus.png') }}" alt="Cover Buku" class="w-full h-72 object-cover rounded shadow-md">
            </div>
          </div>
        </form>
      </div>
    </div>

    <footer class="mt-10 text-center text-gray-600">
      <hr class="my-4 mx-10 border-gray-300">
      <p>© Perpustakaan Teras Baca</p>
    </footer>
  </div>

  <script>
    const idBukuSelect = document.getElementById('id_buku');
    const coverPreview = document.getElementById('coverPreview');
    const form = document.getElementById('formPinjam');

    idBukuSelect.addEventListener('change', function () {
      const selectedOption = this.options[this.selectedIndex];
      const coverUrl = selectedOption.getAttribute('data-cover');
      const selectedId = this.value;

      if (coverUrl) {
        coverPreview.src = coverUrl;
      }

      form.action = selectedId ? `/anggota/pinjam/${selectedId}` : '';
    });
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('/images/perpusbc.jpeg'); /* Pastikan file ini ada di public/images/ */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white">

    <div class="w-full max-w-md p-8 bg-black bg-opacity-60 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-6">Perpustakaan Online</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username"
                    class="w-full px-3 py-2 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('username') }}" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password"
                    class="w-full px-3 py-2 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition duration-200">
                Masuk
            </button>
        </form>

        @if ($errors->any())
            <div class="mt-4 text-red-200 text-sm text-center bg-red-600 bg-opacity-70 p-2 rounded">
                {{ $errors->first() }}
            </div>
        @endif
    </div>

</body>
</html>

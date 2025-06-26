<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teras Baca</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      color: #fff;
    }

    .hero {
      background-image: url('/images/bacasendiri.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      padding: 60px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      position: relative;
    }

    .hero-content {
      background: rgba(255, 255, 255, 0.7);
      padding: 30px;
      border-radius: 16px;
      max-width: 600px;
      color: #000;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1rem;
      max-width: 500px;
      margin-bottom: 30px;
    }

    .hero .btn {
      padding: 12px 28px;
      background-color: #007BFF;
      color: #fff;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s;
    }

    .hero .btn:hover {
      background-color: #0056b3;
    }

    .features-section {
      background-image: url('/images/bacaberdua.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      padding: 100px 30px;
      display: flex;
      justify-content: center;
    }

    .features {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 100%;
      max-width: 1200px;
    }

    .feature-card {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.5);
      color: #000;
      padding: 20px;
      border-radius: 16px;
      flex: 1;
      min-width: 250px;
    }

    .feature-card h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      font-weight: 600;
    }

    @media (min-width: 768px) {
      .features {
        flex-direction: row;
      }
    }

    footer {
      background-color: #2c3e50;
      color: #fff;
      text-align: center;
      padding: 40px 20px 20px;
    }
  </style>
</head>
<body>

  <section class="hero">
    <div class="hero-content">
      <h1>Perpustakaan<br>Teras Baca</h1>
      <p>Selamat datang di Perpustakaan Teras Baca, pusat literasi yang menyediakan akses ke berbagai kategori buku mulai dari, jurnal, artikel, filsafat, novel, Pengetahuan dan dokumen penting dari seluruh Indonesia.</p>
      <a href="{{ route('login') }}" class="btn">Get Started</a>
    </div>
  </section>

  <section class="features-section">
    <div class="features">
      <div class="feature-card">
        <h3>Koleksi Buku Lengkap</h3>
        <p>Akses berbagai kategori buku, filsafat, Pengetahuan dan arsip sejarah yang telah disediakan untuk kebutuhan penelitian dan pembelajaran Anda.</p>
      </div>
      <div class="feature-card">
        <h3>Layanan Peminjaman</h3>
        <p>Cari dan pinjam buku yang anda pilih, lalu ajukan peminjaman pada website yang telah kami sediakan, jangan lupa untuk login terlebih dahulu.</div>
      <div class="feature-card">
        <h3>Akses Gratis untuk Semua</h3>
        <p>Nikmati layanan gratis untuk seluruh mahasiswa. Cukup daftar dan nikmati seluruh fasilitas perpustakaan kami.</p>
      </div>
    </div>
  </section>

  <footer>
    &copy; {{ date('Y') }} Perpustakaan Teras Baca. All rights reserved.
  </footer>

</body>
</html>
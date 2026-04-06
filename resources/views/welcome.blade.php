<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal SDA Kota Palembang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F7F5;
            margin: 0;
        }

        /* NAVBAR */
        nav {
            background: #8A9A5B;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h2 {
            margin: 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
        }

        nav ul li {
            display: inline;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        nav a:hover {
            color: #E6F0EA;
        }

        /* CONTAINER */
        .container {
            padding: 20px 40px;
        }

        /* HERO */
        .hero {
            background: #9CAF88;
            color: white;
            padding: 60px;
            text-align: center;
            border-radius: 12px;
        }

        /* SECTION */
        .section {
            margin-top: 40px;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* CARD */
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h4 {
            margin-top: 0;
            color: #5F6F52;
        }

        .card p {
            color: #555;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #A3B18A;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .card a:hover {
            background: #8A9A5B;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <h2>🌿 Portal SDA</h2>
    <ul>
        <li><a href="/">Beranda</a></li>
        <li><a href="/sda">Data SDA</a></li>
        <li><a href="/news">Berita</a></li>

        @auth
            <li>{{ auth()->user()->name }}</li>
        @else
            <li><a href="/login">Masuk</a></li>
            <li><a href="/register">Daftar</a></li>
        @endauth
    </ul>
</nav>

<div class="container">

    <!-- HERO -->
    <div class="hero">
        <h1>Portal Sumber Daya Alam Kota Palembang</h1>
        <p>Informasi lengkap tentang SDA: Pertanian, Energi, Air, dan Lingkungan</p>
    </div>

    <!-- KATEGORI -->
    <div class="section">
        <h2>Kategori SDA</h2>

        <div class="grid">
            @foreach($categories as $cat)
                <div class="card">
                    <h4>{{ $cat->name }}</h4>
                </div>
            @endforeach
        </div>
    </div>

    <!-- DATA SDA -->
    <div class="section">
        <h2>Data SDA Terbaru</h2>

        <div class="grid">
            @foreach($sdas as $sda)
                <div class="card">
                    <h4>{{ $sda->title }}</h4>
                    <p>{{ $sda->description }}</p>
                    <a href="/detail-sda/{{ $sda->id }}">Detail</a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- BERITA -->
    <div class="section">
        <h2>Berita Terbaru</h2>

        <div class="grid">
            @foreach($news as $n)
                <div class="card">
                    <h4>{{ $n->title }}</h4>
                    <a href="/detail-news/{{ $n->id }}">Baca</a>
                </div>
            @endforeach
        </div>
    </div>

</div>

</body>
</html>
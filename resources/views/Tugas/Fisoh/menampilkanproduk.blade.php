<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cimol Bojot AA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #7a150a, #b84e1a);
            color: white;
        }
        .navbar {
            background-color: #8a1c0f;
        }
        .offcanvas {
            background-color: #62150b;
            color: white;
        }
        .offcanvas a {
            color: #ffc107;
            text-decoration: none;
            display: block;
            padding: 10px;
            width: 100%;
            text-align: center;
        }
        .offcanvas a:hover {
            background-color: #8a1c0f;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark px-3">
        <div class="container-fluid">
            <!-- Tombol Toggle Sidebar (Selalu Tampil) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand ms-2" href="#">Cimol Bojot AA</a>
            <div class="d-flex ms-auto">
                <input class="form-control me-2" type="search" placeholder="Cari produk atau toko" aria-label="Search">
                <button class="btn btn-danger">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Sidebar Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a href="{{ route('dashboard') }}">DASHBOARD</a>
            <a href="#">MENU</a>
            <a href="#">KERANJANG</a>
            <a href="#">PESANAN</a>
            <a href="#">ULASAN</a>
            <a href="#">PROFIL</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="text-warning">Daftar Menu</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigasi Halaman -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




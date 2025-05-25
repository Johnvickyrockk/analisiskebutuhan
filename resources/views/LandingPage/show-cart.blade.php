<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang | CuciSepatu</title> <!-- Dynamic title -->
    <link rel="stylesheet" href="/LandingPage/css/styles.css">
    <link rel="stylesheet" href="/LandingPage/css/blog-detail.css">
    <link rel="stylesheet" href="/LandingPage/css/cart.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#">CuciSepatu</a>
            </div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/blog">Blog</a></li>
            </ul>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="blog-detail-section"> <!-- Reusing class for consistent spacing -->
        <div class="container">
            <div class="blog-detail-content">
                <!-- Title -->
                <h1>Keranjang Layanan</h1>

                @if(isset($cart))
                    @foreach($cart as $item)
                    <div class="cart-item">
                        <h2 class="cart-item-title">{{ $item['name'] }}</h2>
                        <p class="cart-item-meta">Kategori: {{ $item['category'] }}</p>
                        <p class="cart-item-meta">Harga: Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                        <p class="cart-item-meta">Jumlah: {{ $item['quantity'] }}</p>
                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-button">Hapus</button>
                        </form>
                    </div>
                    @endforeach

                    <div class="cart-total">
                        <p class="total-text">Total: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
                        <a href="#" class="checkout-button">Lanjut ke Checkout</a>
                    </div>
                @else
                    <p class="empty-cart-message">Keranjang Anda kosong. Silakan pilih layanan terlebih dahulu.</p>
                    <a href="#" class="back-button">Lihat Layanan</a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <h3 class="footer-logo">CuciSepatu</h3>
                <p class="footer-description">Jasa Cuci Sepatu Modern & Profesional</p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2024 achedev. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Calci Shoes Care</title>
    <link rel="stylesheet" href="{{ asset('/LandingPage/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="{{ route('landingPage') }}">{{ $store->name }}</a>
            </div>
            <button class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </button>
            <ul id="nav-links" class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#tracking">Tracking</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>

                <li>
                    <a href="{{ route('cart') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; height: 24px;">>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Cuci Sepatu Modern, Bersih dan Profesional</h1>
            <p>Percayakan kebersihan sepatu Anda kepada ahli kami. Layanan cuci sepatu cepat dan terpercaya.</p>
        </div>
        <div class="hero-image slideshow-container">
            <!-- Slides -->
            <div class="slide fade">
                <img src="{{ asset('/LandingPage/image/cucisepatu1.jpg') }}" alt="Sepatu Bersih 1">
            </div>
            <div class="slide fade">
                <img src="{{ asset('/LandingPage/image/cucisepatu2.jpg') }}" alt="Sepatu Bersih 2">
            </div>
            <div class="slide fade">
                <img src="{{ asset('/LandingPage/image/cucisepatu3.jpg') }}" alt="Sepatu Bersih 3">
            </div>
            <div class="slide fade">
                <img src="{{ asset('/LandingPage/image/cucisepatu4.jpg') }}" alt="Sepatu Bersih 4">
            </div>
        </div>
    </section>


   


    <!-- Promo Section -->
    <section id="promo" class="promo-section">
        <div class="container">
            <h2>Promo Terbaru</h2>

            @if ($activePromo)
                <!-- Active Promo Banner -->
                <div class="promo-banner">
                    <div class="promo-content">
                        <h3>{{ $activePromo->nama_promosi }}</h3>
                        <p>{{ $activePromo->description }}</p>
                        <p><strong>{{ $activePromo->discount * 100 }}%</strong></p>
                        <p>Berlaku hingga: {{ date('d F Y', strtotime($activePromo->end_date)) }}</p>

                        <!-- Promo Code Box -->
                        <div class="promo-code-box">
                            <p>Gunakan Kode:</p>
                            <div class="promo-code">{{ $activePromo->kode }}</div>
                        </div>
                    </div>

                    <div class="promo-image">
                        <img src="{{ asset($activePromo->image) }}" alt="Promo Diskon">
                    </div>

                    <!-- Terms and Conditions Section (Initially Hidden) -->
                    <div class="promo-terms">
                        <h4>Syarat dan Ketentuan</h4> &nbsp;
                        <p> {{ $activePromo->terms_conditions }}</p>
                    </div>
                </div>
            @else
                <div class="no-active-promo">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Tidak ada Promo Yang Aktif Hari Ini</p>
                </div>
            @endif

            <!-- Other Promos -->
            <div class="promo-cards">
                <!-- Upcoming Promos -->
                @foreach ($upcomingPromos as $promo)
                    <div class="promo-card upcoming">
                        <div class="promo-card-content">
                            <h4>{{ $promo->nama_promosi }}</h4>
                            <p>Diskon: Segera Diumumkan!</p>
                            <p>Kode: Segera Diumumkan!</p>
                            <p>Mulai: {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Expired Promos -->
                @foreach ($expiredPromos as $promo)
                    <div class="promo-card expired">
                        <div class="promo-card-content">
                            <h4>{{ $promo->nama_promosi }}</h4>
                            <p>Diskon: {{ $promo->discount * 100 }}%</p>
                            <p>Kode: {{ $promo->kode }}</p>
                            <p>Kedaluwarsa: {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <h2>About Us</h2>
            <p>Cuci Sepatu adalah layanan cuci sepatu modern yang mengutamakan kualitas dan kepuasan pelanggan. Kami
                menggunakan teknologi dan produk pembersih terbaik untuk memastikan sepatu Anda bersih, wangi, dan
                terlindungi. Dengan tim profesional, kami siap memberikan hasil terbaik untuk sepatu kesayangan Anda.
            </p>
            <p>Jangan biarkan sepatu kotor merusak gaya Anda. Percayakan kebersihan sepatu Anda kepada kami dan rasakan
                perbedaannya!</p>
        </div>


    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <h2>Layanan Kami</h2>
            <p class="description-first">Kami menawarkan layanan perawatan dan pembersihan sepatu terbaik untuk menjaga
                penampilan dan kualitas sepatu Anda. Setiap layanan dirancang untuk memenuhi kebutuhan spesifik Anda dan
                memastikan kepuasan maksimal.</p>
                @foreach ($categories as $categoryLayanan)
    <div class="service-category">
        <h3>{{ $categoryLayanan->treatment_type }}</h3>
        <p>{{ $categoryLayanan->description }}</p>
        <div class="subcategory-container">
            @if ($categoryLayanan->category)
                @foreach ($categoryLayanan->category as $subcategory)
                    <div class="subcategory-item">
                        <strong>{{ $subcategory->nama_kategori }}</strong>
                        <p>{{ $subcategory->description }}</p>
                        <span class="price">Rp {{ number_format($subcategory->price, 0, ',', '.') }}</span>

                        <!-- Form tambah ke keranjang -->
                        <form action="{{ route('cart.add') }}" method="POST" style="margin-top:10px;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $subcategory->id }}">
                            <input type="hidden" name="name" value="{{ $subcategory->nama_kategori }}">
                            <input type="hidden" name="category" value="{{ $categoryLayanan->treatment_type }}">
                            <input type="hidden" name="price" value="{{ $subcategory->price }}">
                            <label for="quantity_{{ $subcategory->id }}">Jumlah:</label>
                            <input type="number" id="quantity_{{ $subcategory->id }}" name="quantity" value="1" min="1" style="width:60px;">
                            <button type="submit">Tambah ke Keranjang</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>No subcategories available.</p>
            @endif
        </div>
    </div>
@endforeach

        </div>
    </section>    
    <!-- Tracking Timeline Section (Modern & Fresh) -->
    <section id="tracking" class="tracking-section">
        <div class="container">
            <h2>Lacak Sepatu Anda</h2>
            <p>Masukkan kode pesanan Anda di bawah ini untuk melacak status layanan sepatu Anda:</p>
            <div class="tracking-form">
                <form id="trackingForm">
                    <div class="form-group">
                        <input type="text" id="trackingCode" name="trackingCode"
                            placeholder="Masukkan Kode Pesanan Anda">
                    </div>
                    <button type="submit" class="cta-button">Lacak Pesanan</button>
                </form>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;">
                Kode pesanan tidak ditemukan. Pastikan Anda memasukkan kode yang benar.
            </div>

            <div id="trackingCodeInfo"
                style="display: none; font-size: 18px; font-weight: bold; margin-bottom: 20px;">
                Kode Tracking: <span id="trackingCodeDisplay"></span>
            </div>

            <!-- Timeline Section (Initially Hidden) -->
            <div id="timelineSection" class="timeline-modern" style="display: none;">
                <!-- Timeline content will be injected here via AJAX -->
                <div id="timelineContent">
                    <!-- Status will be appended here -->
                </div>
                <!-- Button to close the timeline -->
                <button id="closeTimeline" class="cta-button" style="margin-top: 20px;">Tutup Timeline</button>
            </div>

        </div>
    </section>
    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <h2>Hubungi Kami</h2>
            <p>Untuk memberikan saran atau kritik mengenai layanan kami, silakan isi form di samping atau kunjungi
                lokasi kami yang tertera pada peta di bawah ini.</p>

            <div class="contact-wrapper">
                <!-- Form Kontak -->
                <div class="contact-form">
                    <form action="/advice" method="POST" id="adviceForm">
                        @csrf <!-- Tambahkan CSRF Token -->
                        <input type="hidden" id="adviceRoute" value="{{ route('advice') }}">
                        <div class="form-group" id="name-group">
                            <label for="nama">Nama Anda</label>
                            <input type="text" id="nama" name="nama" placeholder="Nama Anda"
                                autocomplete="off">
                        </div>
                        <div class="form-group" id="email-group">
                            <label for="email">Email Anda</label>
                            <input type="email" id="email" name="email" placeholder="Email Anda"
                                autocomplete="off">
                        </div>
                        <div class="form-group" id="advice-group">
                            <label for="advice">Saran/Kritik</label>
                            <textarea id="advice" name="advice" rows="5" placeholder="Tulis saran atau kritik Anda di sini"
                                autocomplete="off"></textarea>
                        </div>
                        <button type="submit" class="cta-button">Kirim Saran/Kritik</button>
                    </form>
                </div>


                <!-- Informasi Kontak -->
                <div class="contact-info">
                    <div id="map" class="maplp" style="height: 200px;"></div>
                    <p style="text-align: justify;">
                        <i class="fas fa-map-marker-alt"></i> {{ $store->address }}
                    </p>
                    <p><i class="fas fa-phone-alt"></i>{{ $store->phone }}</p>
                    <p><i class="fas fa-envelope"></i>{{ $store->email }}</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <h3 class="footer-logo">{{ $store->name }}</h3>
                <p class="footer-description">{{ $store->description }}</p>
                <div class="social-icons">
                    <a href="{{ $store->facebook_url ? $store->facebook_url : '#' }}"
                        target="{{ $store->facebook_url ? '_blank' : '' }}" aria-label="Facebook"
                        onclick="{{ $store->facebook_url ? '' : 'showAlert(event)' }}">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="{{ $store->twitter_url ? $store->twitter_url : '#' }}"
                        target="{{ $store->twitter_url ? '_blank' : '' }}" aria-label="Twitter"
                        onclick="{{ $store->twitter_url ? '' : 'showAlert(event)' }}">
                        <i class="fab fa-twitter"></i>
                    </a>

                    <a href="{{ $store->instagram_url ? $store->instagram_url : '#' }}"
                        target="{{ $store->instagram_url ? '_blank' : '' }}" aria-label="Instagram"
                        onclick="{{ $store->instagram_url ? '' : 'showAlert(event)' }}">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <a href="{{ $store->tiktok_url ? $store->tiktok_url : '#' }}"
                        target="{{ $store->tiktok_url ? '_blank' : '' }}" aria-label="Tiktok"
                        onclick="{{ $store->tiktok_url ? '' : 'showAlert(event)' }}">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2024 achedev. All rights reserved.</p>
            </div>
        </div>

    </footer>
    <button id="backToTop"><i class="fas fa-arrow-up"></i></button>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="{{ asset('/LandingPage/js/tracking.js') }}"></script>
    <script src="{{ asset('/LandingPage/js/advice.js') }}"></script>
    <script src="{{ asset('/LandingPage/js/scroll-to-top.js') }}"></script>
    <script src="{{ asset('/LandingPage/js/aos.js') }}"></script>
    <script>
        function showAlert(event) {
            event.preventDefault(); // Prevent the default link behavior
            Swal.fire({
                icon: 'info',
                title: 'Oops!',
                text: 'The social media link is not available at the moment.',
                confirmButtonText: 'Okay'
            });
        }
    </script>
    <script>
        window.storeLocation = {
            latitude: {!! json_encode($store->latitude) !!},
            longitude: {!! json_encode($store->longitude) !!},
            nama: {!! json_encode($store->name) !!}
        };
    </script>
    <script src="{{ asset('/LandingPage/js/map.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Confetti script running'); // Tambahkan ini untuk cek
            const confettiContainer = document.getElementById('confetti');
            console.log(confettiContainer);
            for (let i = 0; i < 100; i++) {
                const confettiPiece = document.createElement('div');
                console.log(confettiPiece);
                confettiPiece.classList.add('confetti-piece');
                confettiPiece.style.left = Math.random() * 100 + 'vw'; // Random horizontal position
                confettiPiece.style.animationDelay = Math.random() * 5 + 's'; // Random delay
                confettiContainer.appendChild(confettiPiece);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('terms-toggle').addEventListener('click', function() {
                document.querySelector('.promo-content').style.display = 'none';
                document.querySelector('.promo-image').style.display = 'none';
                document.getElementById('promo-terms').style.display = 'block';
            });

            document.getElementById('promo-back').addEventListener('click', function() {
                document.querySelector('.promo-content').style.display = 'block';
                document.querySelector('.promo-image').style.display = 'block';
                document.getElementById('promo-terms').style.display = 'none';
            });
        });
    </script>
    <script>
        document.getElementById('membershipButton').addEventListener('click', function() {
            var membershipForm = document.getElementById('membershipForm');
            var extendMembershipForm = document.getElementById('extendMembershipForm');
            var button = document.getElementById('membershipButton');

            // Sembunyikan form perpanjangan jika terbuka
            if (extendMembershipForm.style.display === "block") {
                extendMembershipForm.style.display = "none"; // Sembunyikan form perpanjangan
                document.getElementById('extendButton').textContent =
                    "Perpanjang Membership Sekarang"; // Reset teks tombol perpanjangan
            }

            // Tampilkan atau sembunyikan form pendaftaran
            if (membershipForm.style.display === "none" || membershipForm.style.display === "") {
                membershipForm.style.display = "block"; // Tampilkan form pendaftaran
                button.textContent = "Tutup Form Membership"; // Ubah teks tombol
            } else {
                membershipForm.style.display = "none"; // Sembunyikan form pendaftaran
                button.textContent = "Daftar Membership Sekarang"; // Ubah teks tombol kembali
            }
        });

        document.getElementById('extendButton').addEventListener('click', function() {
            var membershipForm = document.getElementById('membershipForm');
            var extendMembershipForm = document.getElementById('extendMembershipForm');
            var button = document.getElementById('extendButton');

            // Sembunyikan form pendaftaran jika terbuka
            if (membershipForm.style.display === "block") {
                membershipForm.style.display = "none"; // Sembunyikan form pendaftaran
                document.getElementById('membershipButton').textContent =
                    "Daftar Membership Sekarang"; // Reset teks tombol pendaftaran
            }

            // Tampilkan atau sembunyikan form perpanjangan
            if (extendMembershipForm.style.display === "none" || extendMembershipForm.style.display === "") {
                extendMembershipForm.style.display = "block"; // Tampilkan form perpanjangan
                button.textContent = "Tutup Form Perpanjangan"; // Ubah teks tombol
            } else {
                extendMembershipForm.style.display = "none"; // Sembunyikan form perpanjangan
                button.textContent = "Perpanjang Membership Sekarang"; // Ubah teks tombol kembali
            }
        });
    </script>

    <script>
        // Handle form submission via Ajax dengan konfirmasi dan validasi
        document.getElementById('membershipFormSubmit').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form default

            // Ambil data form
            let formData = new FormData(this);
            let totalPembayaran = parseFloat(formData.get(
                'totalPembayaran')); // Ambil dan ubah totalPembayaran menjadi angka
            let kelasMembership = formData.get('kelas_membership'); // Ambil kelas membership yang dipilih

            // Validasi form: Pastikan semua field diisi
            if (!formData.get('nama_membership') || !formData.get('email_membership') || !formData.get(
                    'phone_membership') ||
                !formData.get('alamat_membership') || !kelasMembership || !formData.get('buktiPembayaran') ||
                !formData.get('totalPembayaran')) {

                // Jika ada field yang kosong, tampilkan SweetAlert error
                Swal.fire({
                    title: 'Error!',
                    text: 'Semua field harus diisi!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return; // Stop jika ada field kosong
            }

            // Validasi total pembayaran berdasarkan kelas membership yang dipilih
            let hargaYangDiharapkan = 0;

            if (kelasMembership === 'standard') {
                hargaYangDiharapkan = 100000; // Harga untuk Standard
            } else if (kelasMembership === 'gold') {
                hargaYangDiharapkan = 250000; // Harga untuk Gold
            } else if (kelasMembership === 'premium') {
                hargaYangDiharapkan = 500000; // Harga untuk Premium
            }

            // Cek apakah total pembayaran sesuai dengan kelas membership yang dipilih
            if (totalPembayaran !== hargaYangDiharapkan) {
                Swal.fire({
                    title: 'Error!',
                    text: `Total pembayaran harus sesuai dengan kelas yang dipilih. Untuk ${kelasMembership}, totalnya harus Rp ${hargaYangDiharapkan}.`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return; // Stop jika total pembayaran tidak sesuai
            }

            // Tampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mendaftarkan membership dengan data ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, daftar sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user mengonfirmasi, kirim form menggunakan fetch
                    fetch("{{ route('membership.register') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Tampilkan SweetAlert sukses
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                document.getElementById('membershipFormSubmit').reset();
                            } else {
                                // Tampilkan SweetAlert error jika ada masalah dari server
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                document.getElementById('membershipFormSubmit').reset();
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat mengirimkan form.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            document.getElementById('membershipFormSubmit').reset();
                        });
                }
            });
        });
    </script>


    <script>
        document.getElementById('extendMembershipFormSubmit').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form default

            // Ambil data form
            let formData = new FormData(this);
            let kodeMembership = formData.get('kode'); // Ambil kode membership
            let kelasMembership = formData.get('kelas_membership'); // Ambil kelas membership yang dipilih

            // Validasi form: Pastikan semua field diisi
            if (!kodeMembership || !formData.get('buktiPembayaran') || !kelasMembership) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Semua field harus diisi!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return; // Stop jika ada field kosong
            }

            // Tampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan memperpanjang membership dengan kode ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, perpanjang sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user mengonfirmasi, kirim form menggunakan fetch
                    fetch("{{ route('memberships.extend') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                document.getElementById('extendMembershipFormSubmit')
                                    .reset(); // Reset form setelah sukses
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat mengirimkan form.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        });
    </script>

    {{-- <script>
        AOS.init({
            duration: 800, // Animation duration
            easing: 'ease-in-out', // Animation easing
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            // Hapus nilai input saat halaman dimuat atau di-refresh
            $('#adviceForm')[0].reset();

            // Tangkap event submit form
            $('#adviceForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form dari submit biasa

                // Ambil data dari form
                var formData = {
                    nama: $('#nama').val(), // Sesuaikan nama field dengan id "nama"
                    email: $('#email').val(),
                    advice: $('#advice').val(),
                };

                // Kirim form menggunakan AJAX
                $.ajax({
                    url: "{{ route('advice') }}", // URL rute yang dituju
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Tambahkan CSRF token ke header
                    },
                    data: formData,
                    success: function(response) {
                        // Menampilkan pesan sukses dengan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: true
                        });

                        // Reset form setelah sukses
                        $('#adviceForm')[0].reset();
                    },
                    error: function(xhr) {
                        // Tampilkan pesan error dari validasi server
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;

                            // Hapus pesan error sebelumnya
                            $('.help-block').remove();
                            $('.has-error').removeClass('has-error');

                            // Tampilkan error jika ada
                            if (errors.nama) { // Ubah 'name' menjadi 'nama'
                                $("#name-group").addClass("has-error");
                                $("#name-group").append('<div class="help-block">' + errors
                                    .nama + "</div>");
                            }
                            if (errors.email) {
                                $("#email-group").addClass("has-error");
                                $("#email-group").append('<div class="help-block">' + errors
                                    .email + "</div>");
                            }
                            if (errors.advice) {
                                $("#advice-group").addClass("has-error");
                                $("#advice-group").append('<div class="help-block">' + errors
                                    .advice + "</div>");
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Silakan coba lagi.',
                                showConfirmButton: true
                            });
                        }
                    }
                });
            });

            $('#nama, #email, #advice').on('input', function() {
                var fieldGroup = $(this).closest(
                    '.form-group'); // Temukan parent .form-group dari elemen yang sedang diinput
                fieldGroup.removeClass('has-error'); // Hapus class error
                fieldGroup.find('.help-block').remove(); // Hapus pesan error
            });
        });
    </script> --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const navLinks = document.getElementById('nav-links');

            hamburger.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
        });
    </script>
    {{-- <script>
        // Ketika pengguna menggulir ke bawah 100px dari bagian atas dokumen, tampilkan tombol
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                document.getElementById("backToTop").style.display = "block";
            } else {
                document.getElementById("backToTop").style.display = "none";
            }
        }

        // Ketika pengguna mengklik tombol, gulir kembali ke bagian atas halaman
        document.getElementById("backToTop").addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Animasi smooth saat kembali ke atas
            });
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('#trackingForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission
                const trackingCode1 = $('#trackingCode').val();
                // Tampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah Anda yakin ingin melacak pesanan dengan kode ${trackingCode1}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lacak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, lakukan pengiriman AJAX

                        // Reset and hide error message, tracking code, and timeline
                        $('#errorMessage').hide();
                        $('#timelineContent').empty(); // Clear previous timeline content
                        $('#trackingCodeInfo').hide(); // Hide tracking code info

                        // Get the tracking code
                        const trackingCode = $('#trackingCode').val();

                        // Perform AJAX request to the server
                        $.ajax({
                            url: '/track-order',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                trackingCode: trackingCode,
                                _token: '{{ csrf_token() }}' // Laravel CSRF token
                            },
                            success: function(response) {
                                // Clear input after success
                                $('#trackingCode').val(''); // Clear input field

                                // Show the tracking code at the top of the timeline
                                $('#trackingCodeDisplay').text(
                                    trackingCode); // Set the tracking code text
                                $('#trackingCodeInfo')
                                    .fadeIn(); // Show the tracking code info

                                // On success, build the timeline dynamically
                                if (response.statuses && response.statuses.length > 0) {
                                    response.statuses.forEach(function(status) {
                                        $('#timelineContent').append(`
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="${getIconForStatus(status.status_name)}"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4>Status: ${status.status_name}</h4>
                                                <p>${status.description}</p>
                                                <span><i class="fas fa-calendar-alt"></i> ${status.date} <i class="fas fa-clock"></i> ${status.time}</span>
                                            </div>
                                        </div>
                                    `);
                                    });
                                    // Show the timeline section
                                    $('#timelineSection').fadeIn();
                                }
                            },
                            error: function(xhr) {
                                // Jika terjadi error, backend akan mengirimkan pesan error
                                if (xhr.status === 404) {
                                    const response = xhr.responseJSON;
                                    $('#errorMessage').html(response
                                        .error); // Tampilkan pesan error dari backend
                                } else {
                                    // Handle error lain jika ada
                                    $('#errorMessage').html(
                                        'Terjadi kesalahan. Silakan coba lagi nanti.'
                                    );
                                }
                                // On error, show the error message
                                $('#trackingCode').val('');
                                $('#errorMessage').fadeIn();

                                setTimeout(() => {
                                    $('#errorMessage').fadeOut();
                                }, 5000);
                            }
                        });
                    }
                });
            });

            // Event handler for the "Tutup Timeline" button
            $('#closeTimeline').on('click', function() {
                $('#timelineSection').fadeOut(); // Hide the timeline when the button is clicked
                $('#trackingCodeInfo').fadeOut(); // Hide the tracking code info as well
            });

            // Function to get appropriate icons based on the status
            function getIconForStatus(statusName) {
                if (statusName === 'Pesanan Diterima') {
                    return 'fas fa-check-circle';
                } else if (statusName === 'Pengerjaan Sedang Berlangsung') {
                    return 'fas fa-spinner';
                } else if (statusName === 'Pesanan Selesai') {
                    return 'fas fa-check-double';
                } else {
                    return 'fas fa-info-circle'; // Default icon
                }
            }
        });
    </script> --}}


    {{-- <script>
        // Initialize the Leaflet map
        var map = L.map('map').setView([-9.0837414, 124.89648], 13); // Coordinates of Atambua

        // Add tile layer from OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker for the store location in Atambua
        L.marker([-9.108398, 124.892494]).addTo(map)
            .bindPopup('Cuci Sepatu Modern')
            .openPopup();
    </script> --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah perubahan URL
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth' // Menambahkan animasi scroll
                    });
                }
            });
        });
    </script>

</body>

</html>

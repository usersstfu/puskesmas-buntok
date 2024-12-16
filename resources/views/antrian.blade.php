<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <title>Sistem Antrian - Puskesmas Buntok</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <style>
        .card-container {
            padding-top: 6rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 600px;
            margin: 20px;
            margin-left: 0rem;
        }

        .card a {
            display: block;
            text-align: center;
            margin: 10px 0;
            padding: 5px;
            background-color: white;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .section {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-item {
            cursor: pointer;
        }
    </style>
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0 align-items-center" style="height: 45px;">
            <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                <div class="d-flex flex-wrap">
                    <a href="#" class="text-light me-4"><i
                            class="fas fa-map-marker-alt text-primary me-2"></i>Buntok, Kalimantan Tengah</a>
                    <a href="#" class="text-light me-4"><i
                            class="fas fa-phone-alt text-primary me-2"></i>(0525)21250</a>
                    <a href="#" class="text-light me-0"><i
                            class="fas fa-envelope text-primary me-2"></i>uptdpkmbuntok@gmail.com</a>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-0"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <a href="/" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fas fa-star-of-life me-3"></i>Puskesmas Buntok</h1>
            </a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto py-0">
                    <li class="nav-item">
                        <a href="/" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Tentang Kami</a>
                        <div class="dropdown-menu">
                            <a href="/sejarah" class="dropdown-item">Sejarah</a>
                            <a href="/visi" class="dropdown-item">Visi dan Misi</a>
                            <a href="/dokter" class="dropdown-item">Dokter</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="/layanan" class="nav-link">Layanan dan Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a href="/kontak" class="nav-link">Kontak Kami</a>
                    </li>
                </ul>
                <a href="/antrian"
                    class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">Sistem
                    Antrian</a>
                @if (Auth::check())
                    <div class="nav-item jojo profile-dropdown">
                        <a class="nav-link nav-icon" href="javascript:void(0)" id="drop2" aria-expanded="false">
                            <img src="../admin/images/profile/empty-profile.png" alt="" width="35"
                                height="35" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <p class="dropdown-item">Halo, {{ Auth::user()->name }}</p>
                                <a href="/profile" class="dropdown-item">My Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="nav-item jojo profile-dropdown">
                        <a class="nav-link nav-icon" href="javascript:void(0)" id="drop2" aria-expanded="false">
                            <img src="../admin/images/profile/empty-profile.png" alt="" width="35"
                                height="35" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <a href="/masuk" class="dropdown-item">Login</a>
                                <a href="/daftar" class="dropdown-item">Daftar Akun</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </nav>
    </div>

    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Sistem Antrian Cerdas Puskesmas
                Buntok</h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-primary">Sistem Antrian</li>
            </ol>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Sistem Antrian Cerdas Puskesmas Buntok</h2>
                        <div class="card-text">
                            <p>Silakan pilih opsi di bawah ini:</p>
                            <a href="daftar" class="btn btn-primary">Daftar Akun</a>
                            <a href="/masuk" class="btn btn-primary">Login</a>
                            <hr>
                            <a href="/daftar-antrian" class="btn btn-primary">Daftar Nomor Antrian</a>
                            <a href="/lihat-antrian" class="btn btn-primary">Lihat Antrian</a>
                            <hr>
                            <a class="btn btn-primary dropdown-toggle" data-bs-toggle="collapse"
                                href="#panduanCollapse" role="button" aria-expanded="false"
                                aria-controls="panduanCollapse">Panduan Penggunaan Sistem Antrian</a>
                            <div class="collapse" id="panduanCollapse">
                                <hr>
                                <p>Berikut adalah langkah-langkah untuk menggunakan sistem antrian:</p>
                                <ul>
                                    <li>Sebelum Mendaftar Nomor Antrian atau Melihat Nomor Antrian yang Ada, Anda
                                        Daftarkan Dulu Akun Anda dengan Mengklik Tombol "Daftar Akun".</li>
                                    <li>Setelah Mendaftar, Login Ke Sistem Menggunakan Akun yang Telah Dibuat Dengan
                                        Mengklik Tombol "Login"</li>
                                    <li>Jika Anda Ingin Mendaftar Nomor Antrian, Silahkan Klik Tombol "Daftar Nomor
                                        Antrian" dan Pilih Ruangan Mana yang Ingin Anda Daftarkan</li>
                                    <li>Anda Dapat Melihat Status Antrian dan Nomor Antrian Anda serta Nomor Antrian
                                        Ruangan Lain Di Halaman "Lihat Antrian".</li>
                                    <li>Datang Ke Puskesmas Sesuai dengan Nomor Antrian yang Telah Anda Dapatkan.</li>
                                    <li>Jika Antrian Anda Masuk Dalam Daftar Tunggu, Silahkan Datangi Admin Ruangan
                                        untuk Memanggilkan Antrian Anda Kembali</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4"><i class="fas fa-star-of-life me-3"></i>Puskesmas
                            Buntok</h4>
                        <p>Website ini sebagai sarana publikasi untuk memberikan Informasi dan
                            gambaran tentang Puskesmas Buntok Kab. Barito Selatan
                        </p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-share fa-2x text-white me-2"></i>
                            <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column flex-fill">
                        <h4 class="mb-4 text-white">Quick Links</h4>
                        <a href="/sejarah"><i class="fas fa-angle-right me-2"></i> Sejarah</a>
                        <a href="/visi"><i class="fas fa-angle-right me-2"></i> Visi dan Misi</a>
                        <a href="/struktur"><i class="fas fa-angle-right me-2"></i> Struktur
                            Organisasi</a>
                        <a href="/dokter"><i class="fas fa-angle-right me-2"></i> Jadwal Dokter</a>
                        <a href="/layanan"><i class="fas fa-angle-right me-2"></i> Layanan dan
                            Fasilitas</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Kontak Kami</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column flex-fill">
                        <h4 class="mb-4 text-white">Contact Info</h4>
                        <a href=""><i class="fa fa-map-marker-alt me-2"></i> 7VP3+4RR, Jl.
                            Pahlawan, Buntok
                            Kota, Kec. Dusun Sel., Kabupaten Barito Selatan, Kalimantan Tengah 73713</a>
                        <a href=""><i class="fas fa-envelope me-2"></i>uptdpkmbuntok@gmail.com</a>
                        <a href=""><i class="fas fa-phone me-2"></i>(0525)21250</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-white"><a href="/"><i
                                class="fas fa-copyright text-light me-2"></i>Puskesmas Buntok, Kab.
                            Barito Selatan</a>, All right
                        reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end text-white">
                    Designed By <a class="border-bottom"
                        href="https://www.linkedin.com/in/dian-putra-anugrahnu-85bb491a6/">DPA</a>
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Perhatian!</h5>
                </div>
                <div class="modal-body">
                    Anda perlu login terlebih dahulu untuk mengakses halaman ini.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <a href="/masuk" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function() {
            var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            if (!isLoggedIn && (window.location.pathname.includes('/daftar-antrian') || window.location.pathname
                    .includes('/lihat-antrian'))) {
                $('#loginModal').modal('show');
            }

            $('#loginModal').on('hidden.bs.modal', function(e) {});

            $('a[href="/daftar-antrian"], a[href="/lihat-antrian"]').click(function(e) {
                if (!isLoggedIn) {
                    e.preventDefault();
                    $('#loginModal').modal('show');
                }
            });

            $('#loginModal button[data-dismiss="modal"]').click(function(e) {
                $('#loginModal').modal('hide');
            });

            $('#loginModal a[href="/masuk"]').click(function(e) {
                if (!isLoggedIn) {
                    window.location.href = '/masuk';
                }
            });
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <title>Puskesmas Buntok</title>
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
    <style>
        .logout-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .close-btn {
            color: white;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: black;
        }
    </style>
</head>

<body>
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
            <a href="/" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fas fa-star-of-life me-3"></i>Puskesmas Buntok</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
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
            </div>
            @if (Auth::check())
                <div class="nav-item">
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
                <div class="nav-item">
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
        </nav>
    </div>
    @if (Session::has('logout_message'))
        <div class="logout-message">
            <span class="close-btn" onclick="closeLogoutMessage()">&times;</span>
            {{ Session::get('logout_message') }}
        </div>
    @endif
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="img/carousel-1.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">UPTD Puskesmas
                        Buntok</h5>
                    <h1 class="display-1 text-capitalize text-white mb-4">Selamat datang di Website Resmi Puskesmas
                        Buntok Kabupaten Barito Selatan</h1>
                    <p class="mb-5 fs-5">Website ini sebagai sarana publikasi untuk memberikan Informasi dan
                        gambaran tentang Puskesmas Buntok Kab. Barito Selatan
                    </p>
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="/antrian">Daftar Antrian</a>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="img/carousel-2.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">UPTD Puskesmas
                        Buntok</h5>
                    <h1 class="display-1 text-capitalize text-white mb-4">Menghadirkan Kenyamanan dan Kesehatan
                        Bersama Puskesmas Buntok</h1>
                    <p class="mb-5 fs-5 animated slideInDown">Terwujudnya pelayanan kesehatan
                        yang prima, optimal, dan bermutu, untuk menjadikan masyarakat wilayah kerja UPT Puskesmas
                        Buntok yang sehat dan Mandiri</p>
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="/antrian">Daftar Antrian</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Pelayanan dan Fasilitas Puskesmas Buntok </h4>
                </div>
                <h1 class="display-3 mb-4">Kenali Fasilitas dan Layanan Kami</h1>
                <p class="mb-0">Puskesmas Buntok hadir untuk melayani kesehatan Anda dan keluarga. Kami menyediakan
                    berbagai fasilitas dan layanan kesehatan yang lengkap, mulai dari pemeriksaan kesehatan umum,
                    imunisasi, hingga layanan ibu dan anak.
                    Dokter dan tenaga medis profesional kami siap membantu Anda mengatasi masalah kesehatan dan menjaga
                    kesehatan Anda secara optimal.</p>
            </div>
            <div class="row g-4 justify-content-center service">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-1.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Sistem Antrian Cerdas</h5>
                                <p class="mb-4">Hemat waktu tunggu di Puskesmas. Sistem antrian pintar kami
                                    memungkinkan Anda daftar online dan melihat perkiraan waktu tunggu, dan kapasitas
                                    ruang tunggu.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-2.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-5" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Rawat Jalan</h5>
                                <p class="mb-4">Layanan Rawat Jalan Puskesmas Buntok tersedia untuk berbagai kondisi
                                    kesehatan non-gawat darurat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-3.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Pemeriksaan Umum</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan layanan pemeriksaan
                                    umum untuk membantu menjaga kesehatan Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-4.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Kesehatan Keluarga (KIA dan KB)</h5>
                                <p class="mb-4">Puskesmas Buntok peduli kesehatan Anda dan keluarga.
                                    Kami menyediakan layanan KIA dan KB untuk memastikan tumbuh kembang optimal anak dan
                                    keluarga terencana. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-5.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Kesehatan Gigi Dan Mulut</h5>
                                <p class="mb-4">Jagalah kesehatan gigi dan mulut Anda di Puskesmas Buntok. Kami
                                    menawarkan layanan konsultasi gigi,
                                    pembersihan gigi, dan perawatan gigi dasar lainnya.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-6.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Imunisasi</h5>
                                <p class="mb-4">Lindungi diri Anda dan keluarga dari penyakit berbahaya dengan
                                    imunisasi di Puskesmas Buntok.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-7.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Farmasi</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan layanan farmasi untuk memenuhi kebutuhan
                                    obat Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-8.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 300px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Laboratorium</h5>
                                <p class="mb-4">Dapatkan hasil tes yang akurat dan terpercaya di Laboratorium
                                    Puskesmas Buntok. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="/layanan">Lihat
                        Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid about bg-light py-3">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-img pb-5 ps-5">
                        <img src="img/about-1.jpg" class="img-fluid rounded w-100"
                            style="object-fit: cover; height: 400px" alt="Image">
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="section-title text-start mb-5">
                        <h4 class="sub-title pe-3 mb-0">Pelayanan Loket Pendaftaran Rawat Jalan</h4>
                        <h1 class="display-4 mb-4">Jadwal Pelayanan UPTD Puskesmas Buntok</h1>
                        <div class="mb-4">
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Senin - Kamis :
                                07.30 - 11.00 WIB</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Jumat : 07.30 -
                                10.00 WIB</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Sabtu : 07.30 -
                                11.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid appointment py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2">
                    <div class="section-title text-start">
                        <h4 class="sub-title pe-3 mb-0">Sistem Antrian Cerdas</h4>
                        <h2 class="display-4 mb-4">Hemat waktu tunggu di Puskesmas</h2>
                        <p class="mb-4">Meningkatkan kualitas pelayanan kesehatan di Puskesmas Buntok
                            dengan mengurangi waktu tunggu pasien, meningkatkan efisiensi
                            pendaftaran, serta memperbaiki proses pelayanan medis melalui sistem
                            antrian cerdas yang inovatif.</p>
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4">
                                        <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Pendaftaran
                                            Online
                                        </h5>
                                        <p class="mb-0">Memungkinkan pengguna untuk mendaftar dan memilih
                                            layanan yang dibutuhkan
                                            untuk mendapatkan nomor antrian secara online melalui
                                            website Puskesmas Buntok. </p>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Melihat
                                            Nomor
                                            Antrian
                                            Secara Real-Time</h5>
                                        <p class="mb-0">Pengguna dapat melihat nomor antrian secara real-time
                                            yang
                                            sedang dilayani, dan dapat datang ke puskesmas ketika nomor
                                            antrian pengguna sebentar lagi akan dipanggil</p>
                                    </div>
                                    <div class="text-start mb-4">
                                        <a href="/antrian"
                                            class="btn btn-primary rounded-pill text-white py-3 px-5">Lihat
                                            Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="video h-100">
                                    <img src="img/video-img.jpg" class="img-fluid rounded w-100 h-100"
                                        style="object-fit: cover;" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">Tata Cara dan Peraturan Penggunaan Sistem Antrian di Puskesmas
                            Buntok</p>
                        <p>Berikut adalah langkah-langkah untuk menggunakan sistem antrian:</p>
                        <ul>
                            <li>Sebelum Mendaftar Nomor Antrian atau Melihat Nomor Antrian yang Ada, Anda
                                Daftarkan Dulu Akun Anda Di Halaman <a href="{{ route('daftar') }}">Daftar Akun</a>.
                            </li>
                            <li>Setelah Mendaftar, Login Ke Sistem Menggunakan Akun yang Telah Dibuat Ke Halaman <a
                                    href="{{ route('login') }}">Login</a>.</li>
                            <li>Jika Anda Ingin Mendaftar Nomor Antrian, Silahkan Ke Halaman <a
                                    href="{{ route('daftarantrian') }}">Daftar Antrian</a> dan Pilih Ruangan Mana yang
                                Ingin Anda Daftarkan.</li>
                            <li>Anda Dapat Melihat Status Antrian dan Nomor Antrian Anda serta Nomor Antrian
                                Ruangan Lain Di Halaman <a href="{{ route('antrian') }}">Sistem Antrian</a>.</li>
                            <li>Datang Ke Puskesmas Sesuai dengan Nomor Antrian yang Telah Anda Dapatkan.</li>
                            <li>Harap Bawa Tanda Pengenal Seperti KTP, SIM, atau Kartu BPJS Anda, untuk Mengklarifikasi
                                Nomor Antrian Anda. <span style="color: red;">(Opsional)</span></li>
                            <li>Jika Antrian Anda Masuk Dalam Daftar Tunggu, Silahkan Datangi Admin Ruangan
                                untuk Memanggilkan Antrian Anda Kembali.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Dokter Puskesmas Buntok</h4>
                </div>
                <h1 class="display-3 mb-4">Tim Medis Profesional Kami</h1>
                <p class="mb-0">Kami dengan bangga mempersembahkan dokter-dokter berkualitas kami di Puskesmas
                    Buntok.
                    Tim medis kami yang berpengalaman dan berdedikasi siap memberikan layanan kesehatan terbaik
                    untuk
                    Anda
                    dan keluarga Anda.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/team-1.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5>Dr. Widyapratiwi Samad</h5>
                            <p class="mb-0">Dokter Umum</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/team-2.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5>Dr. Nova Auditha</h5>
                            <p class="mb-0">Dokter Umum</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/team-3.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5>Dr. Piniel Frimantama</h5>
                            <p class="mb-0">Dokter Umum</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/team-4.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5>Dr. Rusthavia Afrilianti</h5>
                            <p class="mb-0">Doktor Umum</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="/dokter">Lihat
                Selengkapnya</a>
        </div>
    </div>

    <div class="container py-2">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Lokasi Puskesmas Buntok</h4>
            </div>
        </div>
    </div>
    <div class="maps" data-wow-delay="0.3s">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3988.0305966952365!2d114.85267429680555!3d-1.715250206299152!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfb016cca515465%3A0xa91f7ecd21020eac!2sPuskesmas%20Buntok!5e0!3m2!1sid!2sid!4v1711190672041!5m2!1sid!2sid"
            width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" data-wow-delay="0.2"></iframe>
    </div>


    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4"><i class="fas fa-star-of-life me-3"></i>Puskesmas Buntok</h4>
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
                        <a href="/struktur"><i class="fas fa-angle-right me-2"></i> Struktur Organisasi</a>
                        <a href="/dokter"><i class="fas fa-angle-right me-2"></i> Jadwal Dokter</a>
                        <a href="/layanan"><i class="fas fa-angle-right me-2"></i> Layanan dan Fasilitas</a>
                        <a href="/kontak"><i class="fas fa-angle-right me-2"></i> Kontak Kami</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column flex-fill">
                        <h4 class="mb-4 text-white">Info Kontak</h4>
                        <a href=""><i class="fa fa-map-marker-alt me-2"></i> 7VP3+4RR, Jl. Pahlawan, Buntok
                            Kota, Kec. Dusun Sel., Kabupaten Barito Selatan, Kalimantan Tengah 73713</a>
                        <a href=""><i class="fas fa-envelope me-2"></i>uptdpkmbuntok@gmail.com</a>
                        <a href=""><i class="fas fa-phone me-2"></i>(0525)21250</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-white"><a href="#"><i
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

    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script>
        function closeLogoutMessage() {
            var logoutMessage = document.querySelector('.logout-message');
            logoutMessage.style.display = 'none';
        }
    </script>
    <script src="js/main.js"></script>

</body>

</html>

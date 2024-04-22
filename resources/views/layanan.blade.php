<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Layanan dan Fasilitas - Puskesmas Buntok</title>
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
                            <a href="/struktur" class="dropdown-item">Struktur Organisasi</a>
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

    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Layanan dan Fasilitas Kami
                </h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active text-primary">Layanan dan Fasilitas</li>
                </ol>
        </div>
    </div>

    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Pelayanan dan Fasilitas Puskesmas Buntok </h4>
                </div>
                <h1 class="display-3 mb-4">Kenali Fasilitas dan Layanan Kami</h1>
                <p class="mb-0">Puskesmas Buntok hadir untuk melayani kesehatan Anda dan keluarga. Kami
                    menyediakan
                    berbagai fasilitas dan layanan kesehatan yang lengkap, mulai dari pemeriksaan kesehatan umum,
                    imunisasi, hingga layanan ibu dan anak.
                    Dokter dan tenaga medis profesional kami siap membantu Anda mengatasi masalah kesehatan dan
                    menjaga
                    kesehatan Anda secara optimal.</p>
            </div>
            <div class="row g-4 justify-content-center service">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-1.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Sistem Antrian Cerdas</h5>
                                <p class="mb-4">Hemat waktu tunggu di Puskesmas. Sistem antrian pintar kami
                                    memungkinkan Anda daftar online dan melihat perkiraan waktu tunggu, dan
                                    kapasitas
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
                        <div class="service-content rounded-bottom bg-light p-5" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Rawat Jalan</h5>
                                <p class="mb-4">Layanan Rawat Jalan Puskesmas Buntok tersedia untuk berbagai
                                    kondisi
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
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
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
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Kesehatan Keluarga (KIA dan KB)</h5>
                                <p class="mb-4">Puskesmas Buntok peduli kesehatan Anda dan keluarga.
                                    Kami menyediakan layanan KIA dan KB untuk memastikan tumbuh kembang optimal anak
                                    dan
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
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
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
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
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
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Farmasi</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan layanan farmasi untuk memenuhi
                                    kebutuhan
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
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Laboratorium</h5>
                                <p class="mb-4">Dapatkan hasil tes yang akurat dan terpercaya di Laboratorium
                                    Puskesmas Buntok. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-9.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Konsultasi Gizi</h5>
                                <p class="mb-4">Jaga kesehatan Anda dengan konsultasi gizi di Puskesmas Buntok</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-10.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Klinik Sanitasi</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan Klinik Sanitasi
                                    untuk membantu menjaga kebersihan dan kesehatan lingkungan tempat tinggal Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-11.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Administrasi Kesehatan</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan layanan administrasi kesehatan berupa
                                    KIR Kesehatan, dan Surat Keterangan Kesehatan Lainnya</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-12.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Konsultasi Promosi Kesehatan</h5>
                                <p class="mb-4">Konsultasikan cara hidup sehat dan pencegahan penyakit dengan dokter
                                    di Puskesmas Buntok. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-13.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 270px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Pengobatan TB Paru</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan layanan Pengobatan Tuberkulosis (TB)
                                    Paru
                                    yang berkualitas. Layanan ini tersedia untuk semua pasien TB, termasuk yang baru
                                    terdiagnosis dan resisten obat.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-14.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 270px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Pencegahan dan Pengendalian Penyakit (P2P)</h5>
                                <p class="mb-4">Puskesmas Buntok menyediakan layanan P2P yang mudah diakses.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-15.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 270px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">BPJS Kesehatan dan Rujukan</h5>
                                <p class="mb-4">Puskesmas Buntok bekerja sama dengan BPJS Kesehatan untuk
                                    memberikan pelayanan kesehatan yang terjangkau bagi masyarakat.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-16.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 270px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Pemeriksaan Anak (MTBS)</h5>
                                <p class="mb-4">Puskesmas Buntok menawarkan Pemeriksaan Anak
                                    (Mantoux Tuberculin Skin Test - Tes Mantoux) untuk skrining Tuberkulosis (TB) pada
                                    anak.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="img/service-17.jpg" class="img-fluid rounded-top w-100" alt=""
                                style="object-fit: cover;">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4" style="height: 250px;">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Puskesmas Keliling</h5>
                                <p class="mb-4">Puskesmas Keliling adalah layanan kesehatan yang menjangkau
                                    masyarakat
                                    di daerah terpencil yang tidak memiliki akses mudah ke Puskesmas.</p>
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

    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sejarah - Puskesmas Buntok</title>
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
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Sejarah UPTD Puskesmas
                Buntok
                </h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active text-primary">Sejarah</li>
                </ol>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h2 class="mb-3 wow fadeInDown" data-wow-delay="0.1s">Selamat Datang di Halaman Sejarah UPTD Puskesmas
                    Buntok</h2>
                <br>
                <p class="rata wow fadeInDown" data-wow-delay="0.3s">Puskesmas juga merupakan pusat pembangunan
                    kesehatan dengan tujuan
                    meningkatkan kemampuan masyarakat untuk hidup sehat agar dapat terwujudkan derajat kesehatan
                    masyarakat yang optimal,
                    dimana Puskesmas tersebut berada atau disebut <strong>“HEALTH CENTER“</strong>. Sejak tahun 1984
                    fungsi Puskesmas
                    kian berkembang hingga kini,
                    UPT Puskesmas Buntok pada saat dalam melaksanakan kegiatan usaha kesehatan pokok UPT Puskesmas
                    Buntok dibantu oleh Puskesmas Pembantu ,
                    dan pos kesehatan desa, serta jejaringannya.</p>
                <p class="rata wow fadeInDown" data-wow-delay="0.3s">Pada awal berdirinya Puskesmas Buntok mempunyai
                    beban wilayah kerja cukup luas yaitu
                    terdiri dari 19 desa dan 3 kelurahan tapi sesuai dengan perkembangan maka, Pustu Desa Baru
                    ditingkatkan menjadi Puskesmas induk sesuai
                    dengan <strong>SK Bupati Nomor : 87 Tahun 2010</strong>, tanggal 20 Pebruari 2010 dan Pada tahun
                    2012 Puskesmas
                    Buntok kembali dipecah menjadi menjadi UPT Puskesmas
                    <strong>Buntok</strong> dan <strong>Sababilah</strong> sehingga
                    daerah binaan Puskesmas Buntok lebih kecil dari sebelumnya dan tersisa 3 Kelurahan 2 Desa binaan, `
                    maka Puskesmas Buntok yang pada akhirnya mempunyai 3 unit Pustu dan 5 unit Poskesdes ( 3 Kelurahan 2
                    Desa ).
                </p>
                <div class="col-md-12 text-center wow fadeInDown" data-wow-delay="0.1s">
                    <figure>
                        <img src="img/sababilah.png" alt="Puskesmas Sababilah" class="img-fluid" width="800">
                        <figcaption><strong>Puskesmas Sababilah Sekarang</strong></figcaption>
                    </figure>
                </div>
                <br>
                <p class="rata wow fadeInDown" data-wow-delay="0.3s">Untuk menunjang pelaksanaan kegiatan Puskesmas
                    diperlukan system pencatatan yang baik untuk
                    merekam semua kegiatan Puskesmas serta diperlukan pula sistim pelaporan yang sifatnya akurat, tepat
                    waktu, konsisten. Jelaslah bahwa untuk
                    mewujudkan hasil kerja yang baik diperlukan pula kerja yang baik dari semua pihak yang terkait,
                    tentunya juga dari staf yang mengerti akan
                    tugas dan tanggung jawabnya masing – masing.
                    UPT Puskesmas Buntok yang ada sekarang adalah Puskesmas pengganti dari Puskesmas yang kini telah
                    dikembangkan menjadi Rumah Sakit Umum Daerah
                    Kabupaten Barito Selatan dan menjadi Unit Pelayanan Teknis Daerah yang ada dibawah Dinas Kesehatan
                    dan Sekretariat Daerah Kabupaten Barito Selatan.
                </p>
                <br>
                <div class="col-md-12 text-center wow fadeInDown" data-wow-delay="0.1s">
                    <figure>
                        <img src="img/jaragasasameh.png" alt="RSUD Jaraga Sasameh" class="img-fluid" width="800">
                        <figcaption><strong>RSUD Jaraga Sasameh (Rumah Sakit Umum Daerah Kab. Barito Selatan)</strong>
                        </figcaption>
                    </figure>
                </div>
                <br>
                <p class="rata wow fadeInDown" data-wow-delay="0.3s">Puskesmas Buntok awalnya dibangun pada tahun 1984
                    dan mulai aktif berfungsi pada awal maret tahun 1984 terletak di Jalan Tugu dekat Gereja Imanuel.
                    Selama berdirinya puskesmas Buntok telah mengalami beberapa kali pindah, pada
                    tahun 1985 dengan perkembangan kota Buntok, Puskesmas dipindah ke Jalan Pelita tepatnya dibelakang
                    kantor Itwilkab Barito Selatan.
                    Pada tahun 1992 Puskesmas Buntok sudah tidak mampu lagi untuk dikembangkan pembangunan fisiknya
                    karena sudah tidak memadai lagi sebagai Puskesmas perkotaan, pada tahun 1995 lokasi Puskesmas Buntok
                    dipindah kejalan Pahlawan No. 29 RT. 37 Buntok sampai sekarang.
                    Dalam perkembangannya UPT Puskesmas Buntok Sekarang sebagai Puskemas Percontohan sesuai Surat
                    Keputusan Menteri Kesehatan Republik Indonesia nomor : <strong>HK.0107/MENKES/636/2018</strong>
                    Tentang Puskesmas
                    sebagai percontohan.
                    UPT Puskesmas Buntok juga sebagai Puskesmas terakreditasi Madya sesuai Sertifikat Akreditasi
                    Kementerian Kesehatan Komisi Akreditasi FKTP nomor : <strong>YM.02.01/VI.14/2800/2019</strong>
                    tanggal 7 Januari
                    2019.
                    UPT Puskesmas Buntok juga sebagai Puskesmas BLUD (Badan Layanan Umum Daerah) sesuai dengan Surat
                    Keputusan Bupati Barito Selatan Nomor : <strong>188.45/ 433 / 2020</strong> tanggal 23 Desember
                    2020.
                </p>
                <br>
                <div class="col-md-12 text-center wow fadeInDown" data-wow-delay="0.1s">
                    <figure>
                        <img src="img/masajabatan.png" alt="Daftar Kepala UPTD Puskesmas Buntok yang pernah menjabat"
                            class="img-fluid" width="500">
                        <figcaption><strong>Daftar Kepala UPTD Puskesmas Buntok yang pernah menjabat</strong>
                        </figcaption>
                    </figure>
                </div>
                <br>
                <br>
                <div class="col-md-12 text-center wow fadeInDown" data-wow-delay="0.1s">
                    <figure>
                        <img src="img/puskesmasbuntok.png"
                            alt="Daftar Kepala UPTD Puskesmas Buntok yang pernah menjabat" class="img-fluid"
                            width="800">
                        <figcaption><strong>UPTD Puskesmas Buntok Sekarang</strong>
                        </figcaption>
                    </figure>
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
    <script src="js/main.js"></script>
</body>

</html>

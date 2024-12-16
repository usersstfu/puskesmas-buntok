<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <title>Daftar Nomor Antrian - Puskesmas Buntok</title>
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
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Daftar Nomor Antrian
            </h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-primary">Daftar Nomor Antrian</li>
            </ol>
        </div>
    </div>
    <div class="container py-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($antrianSetting->is_active)
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Daftar Nomor Antrian</div>
                        <div class="card-body">
                            <form id="antrianForm" action="{{ route('proses.daftar') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ Auth::user()->name }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        value="{{ Auth::user()->nik }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="ruangan" class="form-label">Ruangan</label>
                                    <select class="form-select" id="ruangan" name="ruangan" required>
                                        <option selected disabled>Pilih Ruangan</option>
                                        <option value="poli_umum">Poli Umum</option>
                                        <option value="poli_gigi">Poli Gigi</option>
                                        <option value="poli_kia">Poli Kia/KB</option>
                                        <option value="poli_anak">Poli Anak</option>
                                        <option value="lab">Laboraturium</option>
                                        <option value="apotik">Apotik</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="card">
                        <div class="card-header">Status Dokumen Identitas</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="bpjs_card_status" class="form-label">Kartu BPJS: </label>
                                @if ($user->bpjs_card)
                                    <span class="badge bg-success">Berkas Ada</span>
                                @else
                                    <span class="badge bg-danger">Berkas Belum Ada</span>
                                    <h6>Anda akan dikenakan biaya Rp.15.000, karena tidak memiliki kartu BPJS</h6>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="ktp_status" class="form-label">KTP: </label>
                                @if ($user->ktp)
                                    <span class="badge bg-success">Berkas Ada</span>
                                @else
                                    <span class="badge bg-danger">Berkas Belum Ada</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="puskesmas_card_status" class="form-label">Kartu Berobat Puskesmas:
                                </label>
                                @if ($user->puskesmas_card)
                                    <span class="badge bg-success">Berkas Ada</span>
                                @else
                                    <span class="badge bg-danger">Berkas Belum Ada</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pendaftaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Nama: <span id="confirmName"></span></p>
                            <p>NIK: <span id="confirmNik"></span></p>
                            <p>Ruangan: <span id="confirmRuangan"></span></p>
                            <p>Tanggal: <span id="confirmDate"></span></p>
                            <p>Status Berkas:</p>
                            <ul>
                                <li>Kartu BPJS: <span id="confirmBpjs" class="badge"></span></li>
                                <li>KTP: <span id="confirmKtp" class="badge"></span></li>
                                <li>Kartu Berobat Puskesmas: <span id="confirmPuskesmas" class="badge"></span></li>
                            </ul>
                            <p>Total Biaya: <span id="confirmBiaya"></span></p>
                            <p id="additionalMessage" class="text-danger"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            <button type="button" class="btn btn-primary" id="confirmSubmit">Ya</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                Pendaftaran antrian tidak tersedia saat ini karena Sistem Antrian sedang dinonaktifkan.
            </div>
        @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('antrianForm');
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            const confirmSubmit = document.getElementById('confirmSubmit');
            const userBpjs = @json($user->bpjs_card);
            const userKtp = @json($user->ktp);
            const userPuskesmas = @json($user->puskesmas_card);

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const name = document.getElementById('nama').value;
                const nik = document.getElementById('nik').value;
                const ruangan = document.getElementById('ruangan').value;
                const ruanganText = document.querySelector('#ruangan option:checked').text;
                const date = new Date().toLocaleDateString('id-ID');

                document.getElementById('confirmName').innerText = name;
                document.getElementById('confirmNik').innerText = nik;
                document.getElementById('confirmRuangan').innerText = ruanganText;
                document.getElementById('confirmDate').innerText = date;

                const bpjsStatus = userBpjs ? 'Berkas Ada' : 'Berkas Belum Ada';
                const bpjsBadgeClass = userBpjs ? 'bg-success' : 'bg-danger';
                document.getElementById('confirmBpjs').innerText = bpjsStatus;
                document.getElementById('confirmBpjs').className = 'badge ' + bpjsBadgeClass;

                const ktpStatus = userKtp ? 'Berkas Ada' : 'Berkas Belum Ada';
                const ktpBadgeClass = userKtp ? 'bg-success' : 'bg-danger';
                document.getElementById('confirmKtp').innerText = ktpStatus;
                document.getElementById('confirmKtp').className = 'badge ' + ktpBadgeClass;

                const puskesmasStatus = userPuskesmas ? 'Berkas Ada' : 'Berkas Belum Ada';
                const puskesmasBadgeClass = userPuskesmas ? 'bg-success' : 'bg-danger';
                document.getElementById('confirmPuskesmas').innerText = puskesmasStatus;
                document.getElementById('confirmPuskesmas').className = 'badge ' + puskesmasBadgeClass;

                const biaya = userBpjs ? 'Rp. 0' : 'Rp. 15.000';
                document.getElementById('confirmBiaya').innerText = biaya;

                const additionalMessages = [];
                if (!userBpjs) {
                    additionalMessages.push(
                        'Sebelum Anda Masuk ke Ruangan Pertama Anda, Harap Anda Bayar Terlebih Dahulu Ke Loket Puskesmas, Terima Kasih'
                    );
                }
                if (!userPuskesmas) {
                    additionalMessages.push(
                        'Sebelum Anda Masuk ke Ruangan Pertama Anda, Harap Anda Membuat Kartu Berobat Puskesmas Buntok Terlebih Dahulu Ke Loket Puskesmas, Terima Kasih'
                    );
                }

                let additionalMessageHtml = '';
                if (additionalMessages.length > 0) {
                    additionalMessageHtml = '<ul>';
                    additionalMessages.forEach(function(message) {
                        additionalMessageHtml += '<li>' + message + '</li>';
                    });
                    additionalMessageHtml += '</ul>';
                }
                document.getElementById('additionalMessage').innerHTML = additionalMessageHtml;

                modal.show();
            });

            confirmSubmit.addEventListener('click', function() {
                form.submit();
            });
        });
    </script>
</body>

</html>

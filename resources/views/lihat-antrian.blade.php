<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lihat Nomor Antrian - Puskesmas Buntok</title>
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
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Lihat Nomor Antrian
            </h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-primary">Lihat Nomor Antrian</li>
            </ol>
        </div>
    </div>

    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- User's information card -->
        @if ($nomorAntrian)
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="bg-primary rounded-circle d-inline-block p-3">
                        <h2 class="text-white m-0">{{ $nomorAntrian->nomor }}</h2>
                    </div>
                    <h5 class="card-title mt-3">Nomor Antrian Anda</h5>
                    <p class="card-text">Nama: <span id="nama_user">{{ $nomorAntrian->nama }}</span></p>
                    <p class="card-text">NIK: <span id="nik_user">{{ $nomorAntrian->nik }}</span></p>
                    <p class="card-text">Ruangan: <span
                            id="ruangan">{{ ucwords(str_replace('_', ' ', $nomorAntrian->ruangan)) }}</span></p>
                    <p class="card-text">Status: <span
                            id="ruangan">{{ ucwords(str_replace('_', ' ', $nomorAntrian->status)) }}</span></p>
                    <p class="card-text">Prioritas: <span id="nik_user">{{ $nomorAntrian->prioritas }}</span></p>
                    <p class="card-text">Prediksi Waktu Tunggu: <span id="waktu_tunggu">30 menit</span></p>
                </div>
            </div>
        @else
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title mt-3">Anda belum memiliki nomor antrian.</h5>
                    <p class="card-text">Silahkan daftar nomor antrian di halaman <a
                            href="{{ route('daftarantrian') }}">Daftar Antrian</a>.</p>
                </div>
            </div>
        @endif
        <div class="row">
            @foreach ($currentQueues as $ruangan => $currentQueue)
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="bg-primary rounded-circle d-inline-block p-3">
                                <h2 class="text-white m-0">
                                    @if ($currentQueue && $currentQueue->status === 'sedang_dilayani')
                                        {{ $currentQueue->nomor }}
                                    @elseif ($currentQueue && strpos($currentQueue->status, 'sedang_dilayani_') !== false)
                                        <span>{{ $currentQueue->nomor }}</span>
                                    @else
                                        0
                                    @endif
                                </h2>
                            </div>
                            <h5 class="card-title mt-3">{{ ucwords(str_replace('_', ' ', $ruangan)) }}</h5>
                            <p class="card-text">Nama:
                                @if ($currentQueue && $currentQueue->status === 'sedang_dilayani')
                                    <span>{{ $currentQueue->nama }}</span>
                                @elseif ($currentQueue && strpos($currentQueue->status, 'sedang_dilayani_') !== false)
                                    <span>{{ $currentQueue->nama }}</span>
                                @else
                                    <span>Belum ada yang dilayani.</span>
                                @endif
                            </p>
                            <div class="card-body text-center">
                                <button class="btn btn-primary btn-block mb-2 showAllQueuesBtn"
                                    data-room="{{ $ruangan }}">Tampilkan Semua Nomor Antrian</button>
                                <button class="btn btn-primary btn-block showWaitListBtn"
                                    data-room="{{ $ruangan }}">Tampilkan Antrian Daftar Tunggu</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var showAllQueuesBtns = document.querySelectorAll('.showAllQueuesBtn');
            var showWaitListBtns = document.querySelectorAll('.showWaitListBtn');
    
            showAllQueuesBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var room = btn.getAttribute('data-room');
                    showQueues(room);
                });
            });
    
            showWaitListBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var room = btn.getAttribute('data-room');
                    showWaitList(room);
                });
            });
    
            function showQueues(room) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/get-all-antrian?room=' + room, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var queues = JSON.parse(xhr.responseText);
                        var modalBody = document.getElementById('allQueuesModalBody');
                        modalBody.innerHTML = '';
    
                        if (queues.length === 0) {
                            var tr = document.createElement('tr');
                            var td = document.createElement('td');
                            td.colSpan = 3;
                            td.textContent = 'Belum ada nomor antrian';
                            tr.appendChild(td);
                            modalBody.appendChild(tr);
                        } else {
                            queues.forEach(function(queue) {
                                if(queue.status !== 'daftar_tunggu') {
                                    var tr = document.createElement('tr');
                                    var tdNomorAntrian = document.createElement('td');
                                    var tdNama = document.createElement('td');
                                    var tdStatus = document.createElement('td');
                                    tdNomorAntrian.textContent = queue.nomor;
                                    tdNama.textContent = queue.nama;
                                    tdStatus.textContent = ucwords(queue.status.replace('_', ' '));
                                    tr.appendChild(tdNomorAntrian);
                                    tr.appendChild(tdNama);
                                    tr.appendChild(tdStatus);
                                    modalBody.appendChild(tr);
                                }
                            });
    
                        }
                        var allQueuesModal = new bootstrap.Modal(document.getElementById('allQueuesModal'));
                        allQueuesModal.show();
                    }
                };
                xhr.send();
            }
    
            function showWaitList(room) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/get-wait-list?room=' + room, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var queues = JSON.parse(xhr.responseText);
                        var modalBody = document.getElementById('waitListModalBody');
                        modalBody.innerHTML = '';
    
                        if (queues.length === 0) {
                            var tr = document.createElement('tr');
                            var td = document.createElement('td');
                            td.colSpan = 3;
                            td.textContent = 'Belum ada nomor antrian';
                            tr.appendChild(td);
                            modalBody.appendChild(tr);
                        } else {
                            queues.forEach(function(queue) {
                                var tr = document.createElement('tr');
                                var tdNomorAntrian = document.createElement('td');
                                var tdNama = document.createElement('td');
                                var tdStatus = document.createElement('td');
                                tdNomorAntrian.textContent = queue.nomor;
                                tdNama.textContent = queue.nama;
                                tdStatus.textContent = ucwords(queue.status.replace('_', ' '));
                                tr.appendChild(tdNomorAntrian);
                                tr.appendChild(tdNama);
                                tr.appendChild(tdStatus);
                                modalBody.appendChild(tr);
                            });
                        }
                        var waitListModal = new bootstrap.Modal(document.getElementById('waitListModal'));
                        waitListModal.show();
                    }
                };
                xhr.send();
            }
    
            function ucwords(str) {
                return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
            }
        });
    </script>    
</body>

</html>

<!-- Modal -->
<div class="modal fade" id="allQueuesModal" tabindex="-1" aria-labelledby="allQueuesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allQueuesModalLabel">Semua Nomor Antrian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nomor Antrian</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="allQueuesModalBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="waitListModal" tabindex="-1" aria-labelledby="waitListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="waitListModalLabel">Antrian Daftar Tunggu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nomor Antrian</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="waitListModalBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Antrian - Puskesmas Buntok</title>
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="../admin/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
                        <img class="mx-4" src="../admin/images/logos/logo.jpg" width="170" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Sistem Antrian Cerdas</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('pengaturan-antrian.index') }}"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Pengaturan Antrian</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('antrian.showPrioritasPage') }}"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Loket</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.poli-umum') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Poli Umum</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.poli-gigi') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Poli Gigi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.poli-kia') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Poli Kia/KB</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.poli-anak') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Poli Anak</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.lab') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Laboraturium</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.apotik') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Apotik</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.riwayat-antrian') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Riwayat Antrian</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pengguna</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.daftar-pengguna') }}"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Daftar Pengguna</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.contacts.index') }}"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-plus"></i>
                                </span>
                                <span class="hide-menu">Ajuan</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Profil</span>
                        </li>
                        <li class="sidebar-item">
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a class="sidebar-link" href="#" onclick="confirmLogout(event)"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../admin/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Halo, {{ Auth::guard('admin')->user()->name }}</p>
                                        </a>
                                        <a href="#" class="btn btn-outline-primary mx-3 mt-2 d-block"
                                            onclick="confirmLogout(event);">
                                            Logout
                                        </a>
                                        <form id="logout-form-dropdown" action="{{ route('admin.logout') }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <br>
            <br>
            <br>
            <br>
            <div class="room-container" id="poli_anak">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <div class="bg-primary rounded-circle d-inline-block p-3">
                                    <h2 class="text-white m-0" id="nomor_antrian">
                                        @if ($currentQueue && $currentQueue->ruangan === 'poli_anak')
                                            {{ $currentQueue->nomor }}
                                        @else
                                            0
                                        @endif
                                    </h2>
                                </div>
                                <h3 class="card-title mt-3">Poli Anak</h3>
                                <h5 class="card-text" id="nama_ruangan">
                                    @if ($currentQueue && $currentQueue->ruangan === 'poli_anak')
                                        {{ $currentQueue->nama }}
                                    @else
                                        Belum ada yang dilayani.
                                    @endif
                                </h5>
                                <p class="card-text">Status Pembayaran: </p>
                                <span
                                    class="badge 
                                        @if ($currentQueue && $currentQueue->status_pembayaran == 'Belum Lunas') bg-danger 
                                        @elseif ($currentQueue && $currentQueue->status_pembayaran == 'BPJS') bg-primary 
                                        @else bg-success @endif">
                                    @if ($currentQueue)
                                        {{ $currentQueue->status_pembayaran }}
                                    @else
                                        -
                                    @endif
                                </span>
                                </p>
                                <button class="btn btn-info mb-2" onclick="toggleBerkas()">Lihat Status
                                    Berkas</button>
                                <div id="statusBerkas" style="display: none;">
                                    @if ($user)
                                        <div class="mb-4">
                                            <label for="ktp" class="form-label">KTP:
                                                <span class="badge {{ $user->ktp ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $user->ktp ? 'Berkas Ada' : 'Berkas Tidak Ada' }}
                                                </span>
                                            </label>
                                            @if ($user->ktp)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $user->ktp) }}"
                                                        target="_blank">Lihat KTP</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-4">
                                            <label for="bpjs" class="form-label">BPJS:
                                                <span
                                                    class="badge {{ $user->bpjs_card ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $user->bpjs_card ? 'Berkas Ada' : 'Berkas Tidak Ada' }}
                                                </span>
                                            </label>
                                            @if ($user->bpjs_card)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $user->bpjs_card) }}"
                                                        target="_blank">Lihat BPJS</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-4">
                                            <label for="puskesmas" class="form-label">Kartu Puskesmas:
                                                <span
                                                    class="badge {{ $user->puskesmas_card ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $user->puskesmas_card ? 'Berkas Ada' : 'Berkas Tidak Ada' }}
                                                </span>
                                            </label>
                                            @if ($user->puskesmas_card)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $user->puskesmas_card) }}"
                                                        target="_blank">Lihat Kartu Puskesmas</a>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p>User tidak ditemukan.</p>
                                    @endif
                                </div>
                                @if (!$currentQueueNumber)
                                    <form method="POST"
                                        action="{{ route('admin.startQueuePoliAnak', ['ruangan' => 'poli_anak']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Mulai</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.pindahkanNomorAntrian') }}"
                                        class="d-flex flex-column">
                                        @csrf
                                        <input type="hidden" name="nomor_antrian" value="{{ $currentQueue->id }}">
                                        <div class="mb-3">
                                            <label for="ruangan_tujuan" class="form-label">Pilih Ruangan
                                                Tujuan:</label>
                                            <select name="ruangan_tujuan" id="ruangan_tujuan" class="form-select">
                                                <option selected disabled>Pilih Ruangan</option>
                                                <option value="poli_gigi">Poli Gigi</option>
                                                <option value="poli_kia">Poli KIA/KB</option>
                                                <option value="poli_umum">Poli Umum</option>
                                                <option value="lab">Laboraturium</option>
                                                <option value="apotik">Apotik</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Pindahkan Antrian</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pindahkanKeDaftarTunggu') }}"
                                        class="d-flex flex-column mt-3">
                                        @csrf
                                        <input type="hidden" name="nomor_antrian" value="{{ $currentQueue->id }}">
                                        <button type="submit" class="btn btn-warning">Pindahkan ke Daftar
                                            Tunggu</button>
                                    </form>
                                    <form method="POST"
                                        action="{{ route('admin.selesaikanAntrianPoliAnak', ['ruangan' => 'poli_anak']) }}"
                                        class="d-flex flex-column mt-3">
                                        @csrf
                                        <input type="hidden" name="nomor_antrian" value="{{ $currentQueue->id }}">
                                        <button type="submit" class="btn btn-danger">Selesai</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Nomor Antrian</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nomor Antrian</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Prioritas</th>
                                            <th>Status Prioritas</th>
                                        </tr>
                                    </thead>
                                    <tbody id="poli_anak_queue_body">
                                        @if (isset($allQueues['poli_anak']))
                                            @foreach ($allQueues['poli_anak'] as $queue)
                                                <tr>
                                                    <td>{{ $queue->nomor }}</td>
                                                    <td>{{ $queue->nama }}</td>
                                                    <td>
                                                        {{ $queue->status }}
                                                        @if ($queue->status == 'daftar_tunggu')
                                                            <form method="POST"
                                                                action="{{ route('admin.panggilKembali') }}"
                                                                class="d-flex flex-column">
                                                                @csrf
                                                                <input type="hidden" name="nomor_antrian"
                                                                    value="{{ $queue->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-warning btn-sm mt-2">Panggil
                                                                    Kembali</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td>{{ $queue->prioritas }}
                                                        @if ($queue->prioritas == 'didahulukan')
                                                            <button type="button" class="btn btn-info btn-sm mt-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#alasanModal{{ $queue->id }}">
                                                                Alasan
                                                            </button>
                                                            <div class="modal fade"
                                                                id="alasanModal{{ $queue->id }}" tabindex="-1"
                                                                aria-labelledby="alasanModalLabel{{ $queue->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="alasanModalLabel{{ $queue->id }}">
                                                                                Alasan Prioritas</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $queue->alasan_prioritas }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Tutup</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $queue->status_prioritas }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">Belum ada antrian untuk hari ini.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="../admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../admin/js/sidebarmenu.js"></script>
    <script src="../admin/js/app.min.js"></script>
    <script src="../admin/libs/simplebar/dist/simplebar.js"></script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            let result = confirm("Apakah Anda yakin ingin logout?");
            if (result) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
    <script>
        function toggleBerkas() {
            var x = document.getElementById("statusBerkas");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</body>

</html>

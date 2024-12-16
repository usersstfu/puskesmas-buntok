<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pengguna - {{ $user->name }} - Puskesmas Buntok</title>
    <link rel="shortcut icon" type="image/png" href="/admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="/admin/css/styles.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn {
            width: 100%;
        }

        table {
            margin-top: 30px;
        }

        table th,
        table td {
            text-align: center;
            vertical-align: middle;
        }

        .modal-content {
            padding: 20px;
        }

        .modal-title {
            font-weight: bold;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .btn-close {
            background: transparent;
            border: none;
        }
    </style>
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
                        <img class="mx-4" src="/admin/images/logos/logo.jpg" width="170" alt="" />
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
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">Detail Pengguna</h3>
                        <p><strong>Nama:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>No. Hp:</strong> {{ $user->phone_number }}</p>
                        <p><strong>Agama:</strong> {{ $user->religion }}</p>
                        <p><strong>Pekerjaan:</strong> {{ $user->occupation }}</p>
                        <p><strong>Tanggal Lahir:</strong> {{ $user->birthdate }}</p>
                        <p><strong>Alamat:</strong> {{ $user->address }}</p>
                        <p><strong>NIK:</strong> {{ $user->nik }}</p>
                        <br>
                        <h5 class="card-title mb-4">Dokumen Identitas :</h5>
                        <div class="mb-4">
                            <label for="ktp" class="form-label">KTP: @if ($user->ktp)
                                    <span class="badge bg-success">Berkas Ada</span>
                                @else
                                    <span class="badge bg-danger">Berkas Belum Ada</span>
                                @endif
                            </label>
                            <div class="mb-2">
                                <a href="{{ asset('storageLink/public/' . $user->ktp) }}" target="_blank">Lihat
                                    KTP</a>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="ktp" class="form-label">BPJS: @if ($user->bpjs_card)
                                    <span class="badge bg-success">Berkas Ada</span>
                                @else
                                    <span class="badge bg-danger">Berkas Belum Ada</span>
                                @endif
                            </label>
                            <div class="mb-2">
                                <a href="{{ asset('storageLink/public/' . $user->bpjs_card) }}" target="_blank">Lihat
                                    BPJS</a>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="ktp" class="form-label">Kartu Puskesmas: @if ($user->puskesmas_card)
                                    <span class="badge bg-success">Berkas Ada</span>
                                @else
                                    <span class="badge bg-danger">Berkas Belum Ada</span>
                                @endif
                            </label>
                            <div class="mb-2">
                                <a href="{{ asset('storageLink/public/' . $user->puskesmas_card) }}"
                                    target="_blank">Lihat
                                    Kartu Puskesmas</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.daftar-pengguna') }}" class="btn btn-primary">Kembali ke Daftar
                        Pengguna</a>
                </div>
            </div>
        </div>
    </div>
    <script src="/admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/admin/js/sidebarmenu.js"></script>
    <script src="/admin/js/app.min.js"></script>
    <script src="/admin/libs/simplebar/dist/simplebar.js"></script>
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
</body>

</html>

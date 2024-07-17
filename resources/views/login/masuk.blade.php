<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="../admin/css/styles.min.css" />
    <style>
        body {
            background-image: url('img/carousel-1.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="../admin/images/logos/logo.jpg" width="180" alt="">
                                </a>
                                <p class="text-center">Puskesmas Buntok</p>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('login.post') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                        <input type="text" class="form-control" id="nik" name="nik"
                                            aria-describedby="nikHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-2 fs-5 mb-4 rounded-2">Sign
                                        In</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Belum Punya Akun ?</p>
                                        <a class="text-primary fw-bold ms-2" href="/daftar">Buat Akun</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="../admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

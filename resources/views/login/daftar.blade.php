<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun</title>
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
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('daftar.post') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            aria-describedby="textHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="phone_number" class="form-label">No. Hp <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="phone_number"
                                            name="phone_number">
                                    </div>
                                    <div class="mb-4">
                                        <label for="religion" class="form-label">Agama <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="religion" name="religion">
                                    </div>
                                    <div class="mb-4">
                                        <label for="occupation" class="form-label">Pekerjaan <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="occupation" name="occupation">
                                    </div>
                                    <div class="mb-4">
                                        <label for="birthdate" class="form-label">Tanggal Lahir <span style="color: red;">*</span></label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate">
                                    </div>
                                    <div class="mb-4">
                                        <label for="address" class="form-label">Alamat <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                    <div class="mb-4">
                                        <label for="ktp" class="form-label">KTP</label>
                                        <input type="file" class="form-control" id="ktp" name="ktp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="bpjs_card" class="form-label">Kartu BPJS</label>
                                        <input type="file" class="form-control" id="bpjs_card" name="bpjs_card">
                                    </div>
                                    <div class="mb-4">
                                        <label for="puskesmas_card" class="form-label">Kartu Berobat Puskesmas
                                            Buntok</label>
                                        <input type="file" class="form-control" id="puskesmas_card"
                                            name="puskesmas_card">
                                    </div>
                                    <p> NIK (Nomor Induk Kependudukan) dan Password digunakan untuk login ke akunnya
                                        nanti </p>
                                    <div class="mb-4">
                                        <label for="nik" class="form-label">NIK (Nomor Induk
                                            Kependudukan) <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="nik" name="nik">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password <span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Konfirmasi
                                            Password <span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-2 fs-5 mb-4 rounded-2">Daftar</button>
                                </form>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">Sudah Punya Akun ?</p>
                                    <a class="text-primary fw-bold ms-2" href="/masuk">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="../admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('password_confirmation').oninput = function() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            if (password !== confirmPassword) {
                document.getElementById('password_confirmation').setCustomValidity('Passwords Tidak Sama.');
            } else {
                document.getElementById('password_confirmation').setCustomValidity('');
            }
        };
    </script>

</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Puskesmas Buntok</title>
    <link rel="shortcut icon" type="image/png" href="../admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="../admin/css/styles.min.css" />
</head>

<body>
    <style>
        .chart-container {
            height: 400px;
        }

        .chart {
            width: 100%;
            height: 100%;
        }

        .summary-section {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .active-button {
            background-color: #007bff;
            /* Blue shade for active state */
            color: white;
        }

        .btn-secondary.active-button {
            background-color: #0056b3;
            /* Darker blue for contrast */
        }
    </style>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
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
                            <span class="hide-menu">Profill</span>
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
        <!--  Sidebar End -->
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="chart-container mb-4">
                            <h3 class="text-center">Grafik Pengunjung</h3>
                            <div id="visitorsChart" class="chart"></div>
                        </div>
                        <div class="chart-container mb-4">
                            <h3 class="text-center">Grafik Pendaftar Nomor Antrian</h3>
                            <div class="btn-group mb-2 mx-4" role="group" aria-label="Queue Charts">
                                <button type="button" class="btn btn-primary"
                                    onclick="showChart('')">Keseluruhan</button>
                                @foreach (['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'] as $room)
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showChart('{{ $room }}')">{{ str_replace('_', ' ', ucfirst($room)) }}</button>
                                @endforeach
                            </div>
                            <div id="queueChart" class="chart queue-chart"></div>
                            @foreach (['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'] as $room)
                                <div id="queueChart{{ $room }}" class="chart queue-chart d-none"></div>
                            @endforeach
                        </div>
                        <div class="chart-container mb-4">
                            <h3 class="text-center">Grafik Nomor Antrian yang Selesai</h3>
                            <div class="btn-group mb-2 mx-4" role="group" aria-label="Completed Charts">
                                <button type="button" class="btn btn-primary"
                                    onclick="showCompletedChart('')">Keseluruhan</button>
                                @foreach (['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'] as $room)
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showCompletedChart('{{ $room }}')">{{ str_replace('_', ' ', ucfirst($room)) }}</button>
                                @endforeach
                            </div>
                            <div id="queueCompletedChart" class="chart completed-chart"></div>
                            @foreach (['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'] as $room)
                                <div id="queueCompletedChart{{ $room }}"
                                    class="chart completed-chart d-none"></div>
                            @endforeach
                        </div>
                        <div class="chart-container mb-4">
                            <h3 class="text-center">Grafik Nomor Antrian yang Tidak Selesai</h3>
                            <div class="btn-group mb-2 mx-4" role="group" aria-label="Not Completed Charts">
                                <button type="button" class="btn btn-primary"
                                    onclick="showNotCompletedChart('')">Keseluruhan</button>
                                @foreach (['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'] as $room)
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showNotCompletedChart('{{ $room }}')">{{ str_replace('_', ' ', ucfirst($room)) }}</button>
                                @endforeach
                            </div>
                            <div id="queueNotCompletedChart" class="chart notcompleted-chart"></div>
                            @foreach (['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'] as $room)
                                <div id="queueNotCompletedChart{{ $room }}"
                                    class="chart notcompleted-chart d-none"></div>
                            @endforeach
                        </div>
                        <div class="chart-container mb-4">
                            <h3 class="text-center">Grafik Pendaftar Akun</h3>
                            <div id="registrationChart" class="chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="summary-section">
                            <h4>Ringkasan Statistik Bulan Ini</h4>
                            <ul>
                                <li>Pengunjung : {{ $totalVisitorsThisMonth }} Pengunjung</li>
                                <li>Nomor Antrian : {{ $queueRegistrationsCount }} Pendaftar</li>
                                <li>Akun : {{ $accountRegistrationsCount }} Akun</li>
                            </ul>
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
    <script src="../admin/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../admin/libs/simplebar/dist/simplebar.js"></script>
    <script src="../admin/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var visitorsData = JSON.parse('{!! $visitorsData !!}');
            var visitorsLabels = JSON.parse('{!! $visitorsLabels !!}');
            var queueData = JSON.parse('{!! $queueData !!}');
            var queueLabels = JSON.parse('{!! $queueLabels !!}');
            var registrationData = JSON.parse('{!! $registrationData !!}');
            var registrationLabels = JSON.parse('{!! $registrationLabels !!}');
            var queueCompletedData = JSON.parse('{!! $queueCompletedData !!}');
            var queueCompletedLabels = JSON.parse('{!! $queueCompletedLabels !!}');
            var queueNotCompletedData = JSON.parse('{!! $queueNotCompletedData !!}');
            var queueNotCompletedLabels = JSON.parse('{!! $queueNotCompletedLabels !!}');

            var visitorsOptions = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Pengunjung',
                    data: visitorsData
                }],
                xaxis: {
                    categories: visitorsLabels
                }
            };

            var queueOptions = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Jumlah Nomor Antrian',
                    data: queueData
                }],
                xaxis: {
                    categories: queueLabels
                }
            };

            var registrationOptions = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Jumlah Akun',
                    data: registrationData
                }],
                xaxis: {
                    categories: registrationLabels
                }
            };

            var queueCompletedOptions = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Antrian Selesai',
                    data: queueCompletedData
                }],
                xaxis: {
                    categories: queueCompletedLabels
                }
            };

            var queueNotCompletedOptions = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Antrian Tidak Selesai',
                    data: queueNotCompletedData
                }],
                xaxis: {
                    categories: queueNotCompletedLabels
                }
            }

            var visitorsChart = new ApexCharts(document.querySelector("#visitorsChart"), visitorsOptions);
            visitorsChart.render();

            var queueChart = new ApexCharts(document.querySelector("#queueChart"), queueOptions);
            queueChart.render();

            var registrationChart = new ApexCharts(document.querySelector("#registrationChart"),
                registrationOptions);
            registrationChart.render();

            var queueCompletedChart = new ApexCharts(document.querySelector("#queueCompletedChart"),
                queueCompletedOptions);
            queueCompletedChart.render();

            var queueNotCompletedChart = new ApexCharts(document.querySelector("#queueNotCompletedChart"),
                queueNotCompletedOptions);
            queueNotCompletedChart.render();
        });
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
        var queueDataByRoom = {!! $queueDataByRoom !!};
        var queueLabelsByRoom = {!! $queueLabelsByRoom !!};

        function showChart(room) {
            const queueCharts = document.querySelectorAll('.queue-chart');
            queueCharts.forEach(chart => chart.classList.add('d-none'));

            const buttons = document.querySelectorAll('.btn-group button');
            buttons.forEach(button => button.classList.remove('active-button'));

            const chartContainerId = 'queueChart' + (room ? room : '');
            const selectedChart = document.getElementById(chartContainerId);
            if (selectedChart) {
                selectedChart.classList.remove('d-none');
                renderChart(room);
            }

            const activeButton = room ? document.querySelector(`button[onclick="showChart('${room}')"]`) : document
                .querySelector('button[onclick="showChart(\'\')"]');
            if (activeButton) {
                activeButton.classList.add('active-button');
            }
        }

        function renderChart(room) {
            var data = room ? queueDataByRoom[room] : queueData;
            var labels = room ? queueLabelsByRoom[room] : queueLabels;

            var options = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Jumlah Nomor Antrian',
                    data: data
                }],
                xaxis: {
                    categories: labels
                }
            };

            var chartElementId = 'queueChart' + (room ? room : '');
            var chartElement = document.querySelector('#' + chartElementId);
            var existingChart = ApexCharts.getChartByID(chartElementId);
            if (existingChart) {
                existingChart.updateOptions(options, true, true, true);
            } else {
                if (chartElement.firstChild) {
                    chartElement.firstChild.remove(); 
                }
                var newChart = new ApexCharts(chartElement, options);
                newChart.render();
            }
        }
    </script>
    <script>
        var queueCompletedDataByRoom = {!! $queueCompletedDataByRoom !!};
        var queueCompletedLabelsByRoom = {!! $queueCompletedLabelsByRoom !!};

        function showCompletedChart(room) {
            const queueCharts = document.querySelectorAll('.completed-chart');
            queueCharts.forEach(chart => chart.classList.add('d-none'));

            const buttons = document.querySelectorAll('.btn-group button');
            buttons.forEach(button => button.classList.remove('active-button'));

            const chartContainerId = 'queueCompletedChart' + (room ? room : '');
            const selectedChart = document.getElementById(chartContainerId);
            if (selectedChart) {
                selectedChart.classList.remove('d-none');
                renderCompletedChart(room);
            }

            const activeButton = room ? document.querySelector(`button[onclick="showCompletedChart('${room}')"]`) : document
                .querySelector('button[onclick="showCompletedChart(\'\')"]');
            if (activeButton) {
                activeButton.classList.add('active-button');
            }
        }

        function renderCompletedChart(room) {
            var data = room ? queueCompletedDataByRoom[room] : queueCompletedData;
            var labels = room ? queueCompletedLabelsByRoom[room] : queueCompletedLabels;

            var options = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Jumlah Nomor Antrian',
                    data: data
                }],
                xaxis: {
                    categories: labels
                }
            };

            var chartElementId = 'queueCompletedChart' + (room ? room : '');
            var chartElement = document.querySelector('#' + chartElementId);
            var existingChart = ApexCharts.getChartByID(chartElementId);
            if (existingChart) {
                existingChart.updateOptions(options, true, true, true);
            } else {
                if (chartElement.firstChild) {
                    chartElement.firstChild.remove(); 
                }
                var newChart = new ApexCharts(chartElement, options);
                newChart.render();
            }
        }
    </script>
    <script>
        var queueNotCompletedDataByRoom = {!! $queueNotCompletedDataByRoom !!};
        var queueNotCompletedLabelsByRoom = {!! $queueNotCompletedLabelsByRoom !!};

        function showNotCompletedChart(room) {
            const queueCharts = document.querySelectorAll('.notcompleted-chart');
            queueCharts.forEach(chart => chart.classList.add('d-none'));

            const buttons = document.querySelectorAll('.btn-group button');
            buttons.forEach(button => button.classList.remove('active-button'));

            const chartContainerId = 'queueNotCompletedChart' + (room ? room : '');
            const selectedChart = document.getElementById(chartContainerId);
            if (selectedChart) {
                selectedChart.classList.remove('d-none');
                renderNotCompletedChart(room);
            }

            const activeButton = room ? document.querySelector(`button[onclick="showNotCompletedChart('${room}')"]`) :
                document
                .querySelector('button[onclick="showNotCompletedChart(\'\')"]');
            if (activeButton) {
                activeButton.classList.add('active-button');
            }
        }

        function renderNotCompletedChart(room) {
            var data = room ? queueNotCompletedDataByRoom[room] : queueNotCompletedData;
            var labels = room ? queueNotCompletedLabelsByRoom[room] : queueNotCompletedLabels;

            var options = {
                chart: {
                    type: 'line',
                    height: '350px'
                },
                series: [{
                    name: 'Jumlah Nomor Antrian',
                    data: data
                }],
                xaxis: {
                    categories: labels
                }
            };

            var chartElementId = 'queueNotCompletedChart' + (room ? room : '');
            var chartElement = document.querySelector('#' + chartElementId);
            var existingChart = ApexCharts.getChartByID(chartElementId);
            if (existingChart) {
                existingChart.updateOptions(options, true, true, true);
            } else {
                if (chartElement.firstChild) {
                    chartElement.firstChild.remove(); 
                }
                var newChart = new ApexCharts(chartElement, options);
                newChart.render();
            }
        }
    </script>
</body>

</html>

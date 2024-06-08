<!DOCTYPE html>
<html>

<head>
    <title>Data Antrian</title>
    <style>
        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Data Antrian</h1>
    <form action="{{ route('generate-nomor-antrian') }}" method="GET">
        @csrf
        <button type="submit">Generate Nomor Antrian</button>
    </form>

    <a href="{{ route('ekspor-data-antrian') }}" class="btn btn-primary">Ekspor Data Antrian ke CSV</a>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('tampilkan-antrian') }}">
        <label for="tanggal">Pilih Tanggal:</label>
        <select name="tanggal" id="tanggal" onchange="this.form.submit()">
            <option value="">Semua Tanggal</option>
            @foreach ($availableDates as $date)
                <option value="{{ $date }}" {{ $tanggal == $date ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </option>
            @endforeach
        </select>
    </form>

    <div>
        <p>Jumlah Sedang Antri: {{ $jumlahSedangAntri }}</p>
        <p>Jumlah Sedang Dilayani: {{ $jumlahSedangDilayani }}</p>
    </div>

    @php
        $ruanganGroups = $antrian->groupBy('ruangan');
    @endphp

    @foreach ($ruanganGroups as $ruangan => $antrianGroup)
        <h2>{{ ucwords(str_replace('_', ' ', $ruangan)) }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Ruangan</th>
                    <th>Nomor</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Waktu Tunggu</th>
                    <th>Waktu Dilayani</th>
                    <th>Waktu Total Sistem</th>
                    <th>Prioritas</th>
                    <th>User ID</th>
                    <th>Status Prioritas</th>
                    <th>Riwayat Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($antrianGroup as $data)
                    <tr>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->nik }}</td>
                        <td>{{ $data->ruangan }}</td>
                        <td>{{ $data->nomor }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td>{{ $data->waktu !== 0 ? gmdate('H:i:s', $data->waktu) : 'Belum antri' }}</td>
                        <td>{{ $data->waktu_dilayani !== 0 ? gmdate('H:i:s', $data->waktu_dilayani) : 'Belum dilayani' }}
                        </td>
                        <td>{{ $data->waktu_total_sistem !== 0 ? gmdate('H:i:s', $data->waktu_total_sistem) : 'Tidak Ada Total waktunya' }}
                        </td>
                        <td>{{ $data->prioritas }}</td>
                        <td>{{ $data->user_id }}</td>
                        <td>{{ $data->status_prioritas }}</td>
                        <td>
                            @if (!empty($data->riwayat_waktu))
                                <ul>
                                    @foreach ($data->riwayat_waktu as $riwayat)
                                        <li>
                                            Ruangan: {{ $riwayat['ruangan'] }},
                                            Waktu Tunggu: {{ gmdate('H:i:s', $riwayat['waktu']) }},
                                            Waktu Dilayani: {{ gmdate('H:i:s', $riwayat['waktu_dilayani']) }},
                                            Diupdated Di Jam :
                                            {{ \Carbon\Carbon::parse($riwayat['updated_at'])->format('H:i:s') }},
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                Tidak ada riwayat.
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

<script>
    setInterval(function() {
        fetch('{{ route('update-waktu-antrian') }}')
            .then(response => response.json())
            .then(data => console.log(data))
            // .then(data => location.reload())
            .catch(error => console.error('Error:', error));
    }, 1000);
</script>

</html>

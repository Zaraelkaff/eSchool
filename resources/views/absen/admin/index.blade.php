<!DOCTYPE html>
<html>
<head>
    <title>Absensi - Index Admin</title>
    <script>
        function autoSubmit() {
            document.getElementById('filter-form').submit();
        }
    </script>
</head>
<body>
    <h1>Data Absensi</h1>
    <a href="{{ route('absen.admin.form') }}">Tambah Absen</a>

    <form id="filter-form" method="GET" action="{{ route('absen.admin.index') }}">
        <label>Kelas:</label>
        <select name="kelas_id" onchange="autoSubmit()">
            <option value="all" {{ $kelasId === 'all' ? 'selected' : '' }}>Semua</option>
            @foreach($masterKelas as $mk)
                <option value="{{ $mk->id }}" {{ $kelasId == $mk->id ? 'selected' : '' }}>{{ $mk->nama_kelas }}</option>
            @endforeach
        </select>

        <label>Tahun Ajaran:</label>
        <select name="tahun_ajaran_id" onchange="autoSubmit()">
            <option value="">Pilih Tahun Ajaran</option>
            @foreach($tahunAjaran as $ta)
                <option value="{{ $ta->id }}" {{ $tahunAjaranId == $ta->id ? 'selected' : '' }}>{{ $ta->tahun_ajaran }}</option>
            @endforeach
        </select>

        <label>Bulan dan Tahun:</label>
        <input type="month" name="month_year" value="{{ $monthYear }}" onchange="autoSubmit()">
    </form>

    @if($errorMessage)
        <p style="color: red;">{{ $errorMessage }}</p>
    @endif

    @if($data)
        @foreach($data as $kelasData)
            <h2>{{ $kelasData['kelas']->master_kelas->nama_kelas }} - {{ $kelasData['kelas']->tahun_ajaran->tahun_ajaran }}</h2>
            <a href="{{ route('absen.admin.form', $kelasData['kelas']->id) }}">Lakukan Absen</a>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nama Murid</th>
                        @foreach($kelasData['days'] as $day)
                            <th>{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelasData['murid'] as $murid)
                        <tr>
                            <td>{{ $murid->nama }}</td>
                            @foreach($kelasData['days'] as $day)
                                @php
                                    $tanggal = Carbon\Carbon::createFromFormat('Y-m', $monthYear)->setDay($day)->format('Y-m-d');
                                    $key = $murid->id . '-' . $tanggal;
                                    $status = $kelasData['absen'][$key]->status ?? '';
                                @endphp
                                <td>{{ $status }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
</body>
</html>
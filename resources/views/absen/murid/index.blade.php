<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Absensi - {{ $namaMurid }}</title>
    <script>
        function autoSubmit() {
            document.getElementById('filter-form').submit();
        }
    </script>
</head>
<body>
    <h1>Riwayat Absensi - {{ $namaMurid }}</h1>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form id="filter-form" method="GET" action="{{ route('absen.murid.index') }}">
        <label>Kelas:</label>
        <select name="kelas_id" onchange="autoSubmit()">
            <option value="all" {{ $kelasId === 'all' ? 'selected' : '' }}>Semua</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->master_kelas->nama_kelas }} - {{ $kelas->tahun_ajaran->tahun_ajaran }}</option>
            @endforeach
        </select>
    </form>

    @if($errorMessage)
        <p style="color: red;">{{ $errorMessage }}</p>
    @endif

    @if($data)
        @foreach($data as $kelasData)
            <h2>{{ $kelasData['kelas']->master_kelas->nama_kelas }} - {{ $kelasData['kelas']->tahun_ajaran->tahun_ajaran }}</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        @foreach($kelasData['days'] as $day)
                            <th>{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelasData['months'] as $month)
                        <tr>
                            <td>{{ $month['label'] }}</td>
                            @foreach($kelasData['days'] as $day)
                                @php
                                    $tanggal = Carbon\Carbon::create($month['year'], $month['month'], $day)->format('Y-m-d');
                                    $status = $kelasData['absen'][$tanggal]->status ?? '';
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
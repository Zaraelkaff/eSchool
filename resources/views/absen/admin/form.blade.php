<!DOCTYPE html>
<html>
<head>
    <title>Absensi - Form Admin</title>
    <script>
        function autoSubmit() {
            document.getElementById('filter-form').submit();
        }
        function setAllHadir() {
            document.querySelectorAll('input[type="radio"][value="H"]').forEach(radio => {
                radio.checked = true;
            });
        }
    </script>
</head>
<body>
    <h1>Form Absensi</h1>

    <form id="filter-form" method="GET" action="{{ route('absen.admin.form') }}">
        <label>Kelas:</label>
        <select name="master_kelas_id" onchange="autoSubmit()">
            <option value="">Pilih Kelas</option>
            @foreach($masterKelas as $mk)
                <option value="{{ $mk->id }}" {{ $masterKelasId == $mk->id ? 'selected' : '' }}>{{ $mk->nama_kelas }}</option>
            @endforeach
        </select>

        <label>Tahun Ajaran:</label>
        <select name="tahun_ajaran_id" onchange="autoSubmit()">
            <option value="">Pilih Tahun Ajaran</option>
            @foreach($tahunAjaran as $ta)
                <option value="{{ $ta->id }}" {{ $tahunAjaranId == $ta->id ? 'selected' : '' }}>{{ $ta->tahun_ajaran }}</option>
            @endforeach
        </select>

        <label>Tanggal:</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="autoSubmit()">
    </form>

    @if($errorMessage)
        <p style="color: red;">{{ $errorMessage }}</p>
    @endif

    @if($data)
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        @if(session('info'))
            <p style="color: blue;">{{ session('info') }}</p>
        @endif
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <h2>{{ $data['kelas']->master_kelas->nama_kelas }} - {{ $data['kelas']->tahun_ajaran->tahun_ajaran }} - {{ \Carbon\Carbon::parse($data['tanggal'])->format('d F Y') }}</h2>
        <form method="POST" action="{{ route('absen.admin.store') }}">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $data['kelas']->id }}">
            <input type="hidden" name="tahun_ajaran_id" value="{{ $data['kelas']->tahun_ajaran_id }}">
            <input type="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
            <button type="button" onclick="setAllHadir()">Hadirkan Semua</button>
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Murid</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['murid'] as $index => $murid)
                        @php
                            $absen = $data['absen'][$murid->id] ?? null;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $murid->nama }}</td>
                            <td>
                                <label><input type="radio" name="status[{{ $murid->id }}]" value="H" {{ $absen && $absen->status === 'H' ? 'checked' : '' }}> Hadir</label>
                                <label><input type="radio" name="status[{{ $murid->id }}]" value="I" {{ $absen && $absen->status === 'I' ? 'checked' : '' }}> Izin</label>
                                <label><input type="radio" name="status[{{ $murid->id }}]" value="S" {{ $absen && $absen->status === 'S' ? 'checked' : '' }}> Sakit</label>
                                <label><input type="radio" name="status[{{ $murid->id }}]" value="A" {{ $absen && $absen->status === 'A' ? 'checked' : '' }}> Alpa</label>
                            </td>
                            <td>
                                <input type="text" name="keterangan[{{ $murid->id }}]" value="{{ $absen ? $absen->keterangan : '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit">Simpan</button>
        </form>
    @endif
</body>
</html>
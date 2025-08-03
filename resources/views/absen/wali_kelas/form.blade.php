<!DOCTYPE html>
<html>
<head>
    <title>Absensi - Form Wali Kelas</title>
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
    <h1>Form Absensi - Wali Kelas</h1>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form id="filter-form" method="GET" action="{{ route('absen.wali_kelas.form') }}">
        <label>Kelas:</label>
        <select name="kelas_id" onchange="autoSubmit()">
            <option value="">Pilih Kelas</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->master_kelas->nama_kelas }}</option>
            @endforeach
        </select>

        <label>Tanggal:</label>
        <span>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</span>
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">
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

        <h2>{{ $data['kelas']->master_kelas->nama_kelas }} - {{ $data['kelas']->tahun_ajaran->tahun_ajaran }} - {{ \Carbon\Carbon::parse($data['tanggal'])->format('d F Y') }}</h2>
        <form method="POST" action="{{ route('absen.wali_kelas.store') }}">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $data['kelas']->id }}">
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
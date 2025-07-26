<h1>Detail Staff: {{ $staff->nama }}</h1>

<!-- Pesan Sukses atau Error -->
@if (session('success'))
    <div class="success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="error">{{ session('error') }}</div>
@endif

<!-- Detail Staff -->
<h2>Data Staff</h2>
<table>
    <tr>
        <th>NIK</th>
        <td>{{ $staff->NIK }}</td>
    </tr>
    <tr>
        <th>Nama</th>
        <td>
            {{ $staff->gelar_depan ? $staff->gelar_depan . ' ' : '' }}
            {{ $staff->nama }}
            {{ $staff->gelar_belakang ? ', ' . $staff->gelar_belakang : '' }}
        </td>
    </tr>
    <tr>
        <th>Jenis Kelamin</th>
        <td>{{ $staff->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
    </tr>
    <tr>
        <th>Tanggal Lahir</th>
        <td>{{ $staff->tgl_lahir }}</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>{{ $staff->alamat }}</td>
    </tr>
    <tr>
        <th>No. Telepon</th>
        <td>{{ $staff->notelp }}</td>
    </tr>
    <tr>
        <th>Lulusan</th>
        <td>{{ $staff->lulusan }}</td>
    </tr>
    <tr>
        <th>Tanggal Masuk</th>
        <td>{{ $staff->tgl_masuk }}</td>
    </tr>
    <tr>
        <th>Tanggal Keluar</th>
        <td>{{ $staff->tgl_keluar ?? '-' }}</td>
    </tr>
</table>

<a href="{{ route('staff.jadwal', $staff->id) }}" class="button">Jadwal Mengajar</a>

<!-- Riwayat Jabatan -->
<h2>Riwayat Jabatan</h2>
@if($staff->jabatan_staff->isEmpty())
    <p>Tidak ada riwayat jabatan.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Jabatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff->jabatan_staff as $js)
                <tr>
                    <td>{{ $js->jabatan->nama_jabatan }}</td>
                    <td>{{ $js->tgl_mulai }}</td>
                    <td>{{ $js->tgl_selesai ?? '-' }}</td>
                    <td>{{ $js->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<!-- Riwayat Kelas -->
<h2>Riwayat Kelas (Wali Kelas)</h2>
@if($staff->kelas->isEmpty())
    <p>Tidak ada riwayat kelas sebagai wali kelas.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Tahun Ajaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff->kelas as $kelas)
                <tr>
                    <td>{{ $kelas->master_kelas->nama_kelas }}</td>
                    <td>{{ $kelas->tahun_ajaran->tahun_ajaran }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<!-- Tombol Navigasi -->
<a href="{{ route('staff.index') }}" class="button">Kembali ke Daftar Staff</a>
<a href="{{ route('staff.editView', $staff->id) }}" class="button">Edit Staff</a>

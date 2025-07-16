<h1>detail data</h1>
<div>NIK : {{ $murid->NIK }}</div>
<div>NIS : {{ $murid->NIS }}</div>
<div>nama: {{ $murid->nama }}</div>
<div>jenis kelamin: {{ $murid->jenis_kelamin }}</div>
<div>tanggal lahir : {{ $murid->tgl_lahir }}</div>
<div>agama : {{ $murid->agama }}</div>
<div>alamat : {{ $murid->alamat }}</div>
<div>notelp : {{ $murid->notelp }}</div>
<div>nama ayah : {{ $murid->nama_ayah }}</div>
<div>nama ibu : {{ $murid->nama_ibu }}</div>
<div>tanggal masuk : {{ $murid->tgl_masuk }}</div>
<div>tanggal keluar : {{ $murid->tgl_keluar }}</div>
<div>status : {{ $murid->is_active }}</div>

<h4>Riwayat Kelas Murid</h4>
<ul>
    @forelse ($murid->kelas as $k)
        <li>
            {{ $k->master_kelas->nama_kelas ?? 'Kelas Kosong' }} -
            {{ $k->tahun_ajaran->tahun_ajaran ?? 'Tahun Ajaran Kosong' }}
        </li>
    @empty
        <li>Belum pernah masuk kelas</li>
    @endforelse
</ul>
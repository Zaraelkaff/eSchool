<!-- Tambahkan jQuery dan Select2 dari CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<h1>{{ $kelas->master_kelas->nama_kelas }} - {{ $kelas->tahun_ajaran->tahun_ajaran }}</h1>
<h2><a href="{{ route('staff.detail', $kelas->wali_kelas_id) }}">{{ $kelas->wali_kelas_id }} - {{ $kelas->walikelas->nama }}</a></h2>
<a href="{{ route('kelas.editView', $kelas->id) }}">edit kelas</a><br><br>
<a href="{{ route('jadwal.index', $kelas->id) }}">Jadwal</a><br><br>
<!-- Menampilkan pesan sukses -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }}
</div>
@endif

<!-- Menampilkan pesan peringatan -->
@if (session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
{{ session('warning') }}
</div>
@endif

<!-- Menampilkan pesan info -->
@if (session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
{{ session('info') }}
</div>
@endif
@if (session('error'))
    <div style="color: red; margin: 10px 0;">{{ session('error') }}</div>
@endif

{{ $kelas->tahun_ajaran->tgl_mulai }} - {{ $kelas->tahun_ajaran->tgl_selesai }} <br>

<h3>Daftar Mapel</h3>
<button onclick="openMapelModal()">Tambah Mapel</button>
@if($kelas->kelasMapel->count())
<ul>
@foreach($kelas->kelasMapel as $k)
    <li>{{ $k->mapel->nama_mapel }} - {{ $k->pengajar->nama }}</li> 
    <a href="{{ route('materi.index', $k->id) }}">Materi</a>
    <form action="{{ route('kelas.mapel.hapus', ['kelas_id' => $kelas->id, 'mapel_id' => $k->mapel_id]) }}" 
        method="POST" style="display:inline;" 
        onsubmit="return confirm('Yakin ingin menghapus {{ $k->mapel->nama_mapel }} dari kelas ini?')">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>
@endforeach
</ul>
@else
    <p>Belum ada mapel</p>
@endif

<h3>Daftar Murid</h3>
<button onclick="openModal()">Tambah Murid</button>
@if ($kelas->murid->count())
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas->murid as $index => $m)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $m->NIK }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>{{ $m->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <th>
                        <a href="{{ route('murid.detail', $m->id) }}">detail</a>
                        <form action="{{ route('kelas.murid.hapus', ['kelas_id' => $kelas->id, 'murid_id' => $m->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus {{ $m->nama }} dari kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Belum ada murid dalam kelas ini</p>
@endif

<hr>
created at: {{ $kelas->created_at }} <br>
updated at: {{ $kelas->updated_at }} <br>
<hr>

<!-- Modal Tambah Murid -->
<div id="tambahMuridModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:white; width:50%; margin:100px auto; padding:20px; border-radius:5px;">
        <h3>Tambah Murid</h3>
        @if (session('error') && session('modal') == 'murid')
            <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
        @endif
        <form action="{{ route('kelas.murid.tambah', $kelas->id) }}" method="POST">
            @csrf
            <div id="muridInputs">
                <div class="murid-row" style="margin-bottom:10px;">
                    <select name="murid_ids[0]" class="murid-select" required style="width:80%;">
                        <option value="" disabled selected>Pilih Murid</option>
                        @foreach ($murids as $murid)
                            <option value="{{ $murid->id }}">{{ $murid->nama }} ({{ $murid->NIK }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($murids->isEmpty())
                <p>Tidak ada murid tersedia untuk ditambahkan.</p>
            @endif
            <button type="button" onclick="tambahBaris('murid')" @if ($murids->isEmpty()) disabled @endif>Tambah Baris</button>
            <button type="submit" @if ($murids->isEmpty()) disabled @endif>Simpan</button>
            <button type="button" onclick="closeModal('tambahMuridModal')">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Tambah Mapel -->
<div id="tambahMapelModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:white; width:50%; margin:100px auto; padding:20px; border-radius:5px;">
        <h3>Tambah Mata Pelajaran</h3>
        @if (session('error') && session('modal') == 'mapel')
            <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
        @endif
        <form action="{{ route('kelas.mapel.tambah', $kelas->id) }}" method="POST">
            @csrf
            <div id="mapelInputs">
                <div class="mapel-row" style="margin-bottom:10px;">
                    <select name="mapel_data[0][mapel_id]" class="mapel-select" required style="width:40%; margin-right:10px;">
                        <option value="" disabled selected>Pilih Mapel</option>
                        @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <select name="mapel_data[0][pengajar_id]" class="pengajar-select" required style="width:40%;">
                        <option value="" disabled selected>Pilih Pengajar</option>
                        @foreach ($pengajars as $pengajar)
                            <option value="{{ $pengajar->id }}">{{ $pengajar->nama }} ({{ $pengajar->NIK }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($mapels->isEmpty() || $pengajars->isEmpty())
                <p>Tidak ada mata pelajaran atau pengajar tersedia untuk ditambahkan.</p>
            @endif
            <button type="button" onclick="tambahBaris('mapel')" @if ($mapels->isEmpty() || $pengajars->isEmpty()) disabled @endif>Tambah Baris</button>
            <button type="submit" @if ($mapels->isEmpty() || $pengajars->isEmpty()) disabled @endif>Simpan</button>
            <button type="button" onclick="closeModal('tambahMapelModal')">Batal</button>
        </form>
    </div>
</div>

<script>
    // Inisialisasi Select2 untuk semua dropdown
    $(document).ready(function() {
        $('.murid-select').select2({
            placeholder: 'Ketik NIK atau Nama',
            allowClear: true,
            width: '100%'
        });
        $('.mapel-select').select2({
            placeholder: 'Pilih Mapel',
            allowClear: true,
            width: '100%'
        });
        $('.pengajar-select').select2({
            placeholder: 'Pilih Pengajar',
            allowClear: true,
            width: '100%'
        });

        // Buka modal yang sesuai jika ada error
        @if (session('error') && session('modal'))
            @if (session('modal') == 'murid')
                openModal();
            @elseif (session('modal') == 'mapel')
                openMapelModal();
            @endif
        @endif
    });

    let muridBarisIndex = 1;
    let mapelBarisIndex = 1;

    function openModal() {
        document.getElementById('tambahMuridModal').style.display = 'block';
    }

    function openMapelModal() {
        document.getElementById('tambahMapelModal').style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function tambahBaris(type) {
        if (type === 'murid') {
            const container = document.getElementById('muridInputs');
            const newRow = document.createElement('div');
            newRow.className = 'murid-row';
            newRow.style.marginBottom = '10px';
            newRow.innerHTML = `
                <select name="murid_ids[${muridBarisIndex}]" class="murid-select" required style="width:70%; margin-right:10px;">
                    <option value="" disabled selected>Pilih Murid</option>
                    @foreach ($murids as $murid)
                        <option value="{{ $murid->id }}">{{ $murid->nama }} ({{ $murid->NIK }})</option>
                    @endforeach
                </select>
                <button type="button" onclick="hapusBaris(this, 'murid')" style="background-color:#f44336; color:white; padding:8px 12px; border:none; border-radius:3px; cursor:pointer;">Hapus</button>
            `;
            container.appendChild(newRow);
            $(newRow).find('.murid-select').select2({
                placeholder: 'Ketik NIK atau Nama',
                allowClear: true,
                width: '100%'
            });
            muridBarisIndex++;
        } else if (type === 'mapel') {
            const container = document.getElementById('mapelInputs');
            const newRow = document.createElement('div');
            newRow.className = 'mapel-row';
            newRow.style.marginBottom = '10px';
            newRow.innerHTML = `
                <select name="mapel_data[${mapelBarisIndex}][mapel_id]" class="mapel-select" required style="width:40%; margin-right:10px;">
                    <option value="" disabled selected>Pilih Mapel</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
                <select name="mapel_data[${mapelBarisIndex}][pengajar_id]" class="pengajar-select" required style="width:40%;">
                    <option value="" disabled selected>Pilih Pengajar</option>
                    @foreach ($pengajars as $pengajar)
                        <option value="{{ $pengajar->id }}">{{ $pengajar->nama }} ({{ $pengajar->NIK }})</option>
                    @endforeach
                </select>
                <button type="button" onclick="hapusBaris(this, 'mapel')" style="background-color:#f44336; color:white; padding:8px 12px; border:none; border-radius:3px; cursor:pointer;">Hapus</button>
            `;
            container.appendChild(newRow);
            $(newRow).find('.mapel-select').select2({
                placeholder: 'Pilih Mapel',
                allowClear: true,
                width: '100%'
            });
            $(newRow).find('.pengajar-select').select2({
                placeholder: 'Pilih Pengajar',
                allowClear: true,
                width: '100%'
            });
            mapelBarisIndex++;
        }
    }

    function hapusBaris(button, type) {
        const rows = document.querySelectorAll(`.${type}-row`);
        if (rows.length > 1) {
            button.parentElement.remove();
            if (type === 'murid') {
                muridBarisIndex--;
            } else if (type === 'mapel') {
                mapelBarisIndex--;
            }
        } else {
            alert('Minimal satu baris harus tetap ada.');
        }
    }

    // Tutup modal jika klik di luar form
    window.onclick = function(event) {
        const muridModal = document.getElementById('tambahMuridModal');
        const mapelModal = document.getElementById('tambahMapelModal');
        if (event.target == muridModal) {
            closeModal('tambahMuridModal');
        } else if (event.target == mapelModal) {
            closeModal('tambahMapelModal');
        }
    }
</script>

<style>
    button {
        padding: 8px 12px;
        margin: 5px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        background-color: #4CAF50;
        color: white;
    }
    button[type="button"]:last-child {
        background-color: #f44336;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 6px;
        height: 34px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 22px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 32px;
    }
</style>
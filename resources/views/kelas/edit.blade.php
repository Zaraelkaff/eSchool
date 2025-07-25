<!-- Tambahkan jQuery dan Select2 dari CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<h2>Edit {{ $kelas->master_kelas->nama_kelas }} - {{ $kelas->tahun_ajaran->tahun_ajaran }}</h2>
<a href="{{ route('kelas.index') }}">Kembali</a>
@if ($errors->has('kombinasi'))
    <div>{{ $errors->first('kombinasi') }}</div>
@endif
<form action="{{ route('kelas.edit', $kelas->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <label for="master_kelas_id">Nama Kelas:</label><br>
    <select name="master_kelas_id" required>
        <option value="">-- Pilih --</option>
        @foreach($masterKelas as $mk)
            <option value="{{ $mk->id }}" {{ $kelas->master_kelas_id == $mk->id ? 'selected' : '' }}>
                {{ $mk->nama_kelas }}
            </option>
        @endforeach
    </select>
    @error('master_kelas_id')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <!-- Field Tahun Ajaran -->
    <label for="tahun_ajaran_id">Tahun Ajaran:</label><br>
    <select name="tahun_ajaran_id" required>
        <option value="">-- Pilih --</option>
        @foreach($tahunAjaran as $ta)
            <option value="{{ $ta->id }}" {{ $kelas->tahun_ajaran_id == $ta->id ? 'selected' : '' }}>
                {{ $ta->tahun_ajaran }}
            </option>
        @endforeach
    </select>
    @error('tahun_ajaran_id')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <!-- Field Wali Kelas -->
    <label for="wali_kelas_id">Wali Kelas:</label><br>
    <select name="wali_kelas_id" required>
        <option value="">-- Pilih --</option>
        @foreach($guru as $wk)
            <option value="{{ $wk->id }}" {{ $kelas->wali_kelas_id == $wk->id ? 'selected' : '' }}>
                {{ $wk->nama }}
            </option>
        @endforeach
    </select>
    @error('wali_kelas_id')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <!-- Field Status -->
    <label for="is_active">Status:</label><br>
    <select name="is_active" required>
        <option value="1" {{ $kelas->is_active == '1' ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ $kelas->is_active == '0' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
    @error('is_active')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <button type="submit">Simpan Kelas</button>
</form>
<hr>
created at: {{ $kelas->created_at }} <br>
updated at: {{ $kelas->updated_at }} <br>
<hr>
@if (session('success'))
    <div style="color: green; margin: 10px 0;">{{ session('success') }}</div>
@endif
@if (session('warning'))
    <div style="color: orange; margin: 10px 0;">{{ session('warning') }}</div>
@endif
@if (session('error'))
    <div style="color: red; margin: 10px 0;">{{ session('error') }}</div>
@endif


<h3>Daftar Mapel</h3>
<button onclick="openMapelModal()">Tambah Mapel</button>
@if($kelas->kelasMapel->count())
<ul>
@foreach($kelas->kelasMapel as $k)
    <li>{{ $k->mapel->nama_mapel }} - {{ $k->pengajar->nama }}</li> 
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
                        @foreach ($guru as $pengajar)
                            <option value="{{ $pengajar->id }}">{{ $pengajar->nama }} ({{ $pengajar->NIK }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($mapels->isEmpty() || $guru->isEmpty())
                <p>Tidak ada mata pelajaran atau pengajar tersedia untuk ditambahkan.</p>
            @endif
            <button type="button" onclick="tambahBaris('mapel')" @if ($mapels->isEmpty() || $guru->isEmpty()) disabled @endif>Tambah Baris</button>
            <button type="submit" @if ($mapels->isEmpty() || $guru->isEmpty()) disabled @endif>Simpan</button>
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
                    @foreach ($guru as $pengajar)
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

<!-- CSS untuk Styling Minimal -->
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
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
        @foreach($waliKelas as $wk)
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

<h3>Daftar Murid</h3>
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

<!-- Tombol Tambah Murid -->
<button onclick="openModal()">Tambah Murid</button>

<!-- Modal -->
<div id="tambahMuridModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:white; width:50%; margin:100px auto; padding:20px; border-radius:5px;">
        <h3>Tambah Murid</h3>
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
            <button type="button" onclick="tambahBaris()" @if ($murids->isEmpty()) disabled @endif>Tambah Baris</button>
            <button type="submit" @if ($murids->isEmpty()) disabled @endif>Simpan</button>
            <button type="button" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

<!-- JavaScript untuk Modal, Tambah Baris, Hapus Baris, dan Inisialisasi Select2 -->
<script>
    // Inisialisasi Select2 untuk semua dropdown dengan kelas .murid-select
    $(document).ready(function() {
        $('.murid-select').select2({
            placeholder: 'Ketik NIK atau Nama',
            allowClear: true,
            width: '100%'
        });
    });

    let barisIndex = 1;

    function openModal() {
        document.getElementById('tambahMuridModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('tambahMuridModal').style.display = 'none';
    }

    function tambahBaris() {
        const container = document.getElementById('muridInputs');
        const newRow = document.createElement('div');
        newRow.className = 'murid-row';
        newRow.style.marginBottom = '10px';
        newRow.innerHTML = `
            <select name="murid_ids[${barisIndex}]" class="murid-select" required style="width:70%; margin-right:10px;">
                <option value="" disabled selected>Pilih Murid</option>
                @foreach ($murids as $murid)
                    <option value="{{ $murid->id }}">{{ $murid->nama }} ({{ $murid->NIK }})</option>
                @endforeach
            </select>
            <button type="button" onclick="hapusBaris(this)" style="background-color:#f44336; color:white; padding:8px 12px; border:none; border-radius:3px; cursor:pointer;">Hapus</button>
        `;
        container.appendChild(newRow);
        // Inisialisasi Select2 untuk dropdown baru
        $(newRow).find('.murid-select').select2({
            placeholder: 'Ketik NIK atau Nama',
            allowClear: true,
            width: '100%'
        });
        barisIndex++;
    }

    function hapusBaris(button) {
        if (document.querySelectorAll('.murid-row').length > 1) {
            button.parentElement.remove();
            barisIndex--;
        } else {
            alert('Minimal satu baris harus tetap ada.');
        }
    }

    // Tutup modal jika klik di luar form
    window.onclick = function(event) {
        const modal = document.getElementById('tambahMuridModal');
        if (event.target == modal) {
            closeModal();
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
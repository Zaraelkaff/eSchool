<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Tahun Ajaran</title>
    <style>
        .hidden { display: none; }
        .modal {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, 0);
            background-color: white;
            border: 1px solid #aaa;
            padding: 15px;
            z-index: 10;
        }
        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.3);
            z-index: 5;
        }
    </style>
</head>
<body>

<h2>Master Tahun Ajaran</h2>

<button onclick="bukaModalTambah()">Tambah Tahun Ajaran</button>

<form method="GET" action="{{ route('master.tahunajaran.index') }}" style="margin-top: 10px;">
    <label for="filter">Filter Status:</label>
    <select name="filter" id="filter" onchange="this.form.submit()">
        <option value="aktif" {{ (isset($filter) && $filter === 'aktif') ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ (isset($filter) && $filter === 'nonaktif') ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="semua" {{ (isset($filter) && $filter === 'semua') ? 'selected' : '' }}>Semua</option>
    </select>
</form>

<table border="1" cellpadding="5" cellspacing="0" style="margin-top:10px;">
    <thead>
        <tr>
            <th>No</th>
            <th>Tahun Ajaran</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Jumlah Kelas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataTahunAjaran as $index => $ta)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $ta->tahun_ajaran }}</td>
            <td>{{ $ta->tgl_mulai }}</td>
            <td>{{ $ta->tgl_selesai }}</td>
            <td>{{ $ta->kelas_count }} kelas</td>
            <td>{{ $ta->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td>
                <form action="{{ route('master.tahunajaran.isActive', $ta->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit">{{ $ta->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                </form>
                <button onclick="bukaModalEdit({{ $ta->id }}, '{{ $ta->tahun_ajaran }}', '{{ $ta->tgl_mulai }}', '{{ $ta->tgl_selesai }}', {{ $ta->is_active }})">Edit</button>
                <button onclick="bukaModalKelas({{ $ta->id }})">Lihat Kelas</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah -->
<div id="modalTambah" class="{{ old('form_mode') === 'tambah' && $errors->any() ? '' : 'hidden' }}">
    <div class="overlay" onclick="tutupModalTambah()"></div>
    <div class="modal">
        <h3>Tambah Tahun Ajaran</h3>
        <form action="{{ route('master.tahunajaran.add') }}" method="POST">
            @csrf
            <input type="hidden" name="form_mode" value="tambah">
            <input type="hidden" name="tahun_ajaran" id="tahun_ajaran_tambah">

            <label>Tahun Ajaran</label><br>
            <input type="number" name="tahun_mulai" id="tahun_mulai_tambah" value="{{ old('form_mode') === 'tambah' ? old('tahun_mulai') : '' }}" required oninput="updateTahunAjaranTambah()">
            <span>/</span>
            <input type="number" name="tahun_selesai" id="tahun_selesai_tambah" disabled><br>
            @if(old('form_mode') === 'tambah')
                @error('tahun_ajaran')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Tanggal Mulai</label><br>
            <input type="date" name="tgl_mulai" id="tgl_mulai_tambah" value="{{ old('form_mode') === 'tambah' ? old('tgl_mulai') : '' }}" required><br>
            @if(old('form_mode') === 'tambah')
                @error('tgl_mulai')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Tanggal Selesai</label><br>
            <input type="date" name="tgl_selesai" id="tgl_selesai_tambah" value="{{ old('form_mode') === 'tambah' ? old('tgl_selesai') : '' }}" required><br>
            @if(old('form_mode') === 'tambah')
                @error('tgl_selesai')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Status</label><br>
            <select name="is_active" required>
                <option value="1" {{ old('form_mode') === 'tambah' && old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('form_mode') === 'tambah' && old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select><br>
            @if(old('form_mode') === 'tambah')
                @error('is_active')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <div style="margin-top:10px;">
                <button type="submit">Simpan</button>
                <button type="button" onclick="window.location.href='{{ route('master.tahunajaran.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="{{ old('form_mode') === 'edit' && $errors->any() ? '' : 'hidden' }}">
    <div class="overlay" onclick="tutupModalEdit()"></div>
    <div class="modal">
        <h3>Edit Tahun Ajaran</h3>
        <form id="formEdit" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="form_mode" value="edit">
            <input type="hidden" name="edit_id" id="edit_id" value="{{ old('edit_id') }}">
            <input type="hidden" name="tahun_ajaran" id="tahun_ajaran_edit">

            <label>Tahun Ajaran</label><br>
            <input type="number" name="tahun_mulai" id="tahun_mulai_edit" value="{{ old('form_mode') === 'edit' ? old('tahun_mulai') : '' }}" required oninput="updateTahunAjaranEdit()">
            <span>/</span>
            <input type="number" name="tahun_selesai" id="tahun_selesai_edit" disabled><br>
            @if(old('form_mode') === 'edit')
                @error('tahun_ajaran')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Tanggal Mulai</label><br>
            <input type="date" name="tgl_mulai" id="editMulai" value="{{ old('form_mode') === 'edit' ? old('tgl_mulai') : '' }}" required><br>
            @if(old('form_mode') === 'edit')
                @error('tgl_mulai')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Tanggal Selesai</label><br>
            <input type="date" name="tgl_selesai" id="editSelesai" value="{{ old('form_mode') === 'edit' ? old('tgl_selesai') : '' }}" required><br>
            @if(old('form_mode') === 'edit')
                @error('tgl_selesai')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Status</label><br>
            <select name="is_active" id="editStatus" required>
                <option value="1" {{ old('form_mode') === 'edit' && old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('form_mode') === 'edit' && old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select><br>
            @if(old('form_mode') === 'edit')
                @error('is_active')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <div style="margin-top:10px;">
                <button type="submit">Update</button>
                <button type="button" onclick="window.location.href='{{ route('master.tahunajaran.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Lihat Kelas -->
<div id="modalKelas" class="hidden">
    <div class="overlay" onclick="tutupModalKelas()"></div>
    <div class="modal">
        <h3>Daftar Kelas</h3>
        <div id="kelasContent">Memuat...</div>
        <div style="margin-top:10px;">
            <button onclick="tutupModalKelas()">Tutup</button>
        </div>
    </div>
</div>

<script>
    const daftarTA = @json($dataTahunAjaran);

    function bukaModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
        updateTahunAjaranTambah();
    }
    function tutupModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function updateTahunAjaranTambah() {
        const tahunMulai = document.getElementById('tahun_mulai_tambah').value;
        const tahunSelesai = parseInt(tahunMulai) + 1;
        document.getElementById('tahun_selesai_tambah').value = tahunSelesai;
        document.getElementById('tahun_ajaran_tambah').value = tahunMulai ? `${tahunMulai}/${tahunSelesai}` : '';
        
        // Batasi tahun untuk tgl_mulai
        const tglMulai = document.getElementById('tgl_mulai_tambah');
        tglMulai.min = `${tahunMulai}-01-01`;
        tglMulai.max = `${tahunMulai}-12-31`;
        // Reset tgl_mulai jika tahun tidak sesuai
        if (tglMulai.value && new Date(tglMulai.value).getFullYear() != tahunMulai) {
            tglMulai.value = '';
        }
        
        // Batasi tahun untuk tgl_selesai
        const tglSelesai = document.getElementById('tgl_selesai_tambah');
        tglSelesai.min = `${tahunSelesai}-01-01`;
        tglSelesai.max = `${tahunSelesai}-12-31`;
        // Reset tgl_selesai jika tahun tidak sesuai
        if (tglSelesai.value && new Date(tglSelesai.value).getFullYear() != tahunSelesai) {
            tglSelesai.value = '';
        }
    }

    function updateTahunAjaranEdit() {
        const tahunMulai = document.getElementById('tahun_mulai_edit').value;
        const tahunSelesai = parseInt(tahunMulai) + 1;
        document.getElementById('tahun_selesai_edit').value = tahunSelesai;
        document.getElementById('tahun_ajaran_edit').value = tahunMulai ? `${tahunMulai}/${tahunSelesai}` : '';
        
        // Batasi tahun untuk tgl_mulai
        const tglMulai = document.getElementById('editMulai');
        tglMulai.min = `${tahunMulai}-01-01`;
        tglMulai.max = `${tahunMulai}-12-31`;
        // Reset tgl_mulai jika tahun tidak sesuai
        if (tglMulai.value && new Date(tglMulai.value).getFullYear() != tahunMulai) {
            tglMulai.value = '';
        }
        
        // Batasi tahun untuk tgl_selesai
        const tglSelesai = document.getElementById('editSelesai');
        tglSelesai.min = `${tahunSelesai}-01-01`;
        tglSelesai.max = `${tahunSelesai}-12-31`;
        // Reset tgl_selesai jika tahun tidak sesuai
        if (tglSelesai.value && new Date(tglSelesai.value).getFullYear() != tahunSelesai) {
            tglSelesai.value = '';
        }
    }

    function bukaModalEdit(id, tahunAjaran, tglMulai, tglSelesai, isActive) {
        const form = document.getElementById('formEdit');
        form.action = `/master/tahunajaran/edit/${id}`;
        document.getElementById('edit_id').value = id;
        
        // Split tahun_ajaran untuk mendapatkan tahun mulai
        const [tahunMulai] = tahunAjaran.split('/');
        document.getElementById('tahun_mulai_edit').value = tahunMulai;
        document.getElementById('tahun_selesai_edit').value = parseInt(tahunMulai) + 1;
        document.getElementById('tahun_ajaran_edit').value = tahunAjaran;
        
        // Set tanggal untuk input date
        document.getElementById('editMulai').value = tglMulai;
        document.getElementById('editSelesai').value = tglSelesai;
        
        document.getElementById('editStatus').value = isActive ? '1' : '0';
        document.getElementById('modalEdit').classList.remove('hidden');
        
        // Update batasan tahun
        updateTahunAjaranEdit();
    }
    function tutupModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }

    function bukaModalKelas(id) {
        const ta = daftarTA.find(item => item.id === id);
        let html = '';

        if (!ta || !ta.kelas.length) {
            html = '<p>Tidak ada kelas.</p>';
        } else {
            html += '<ul>';
            ta.kelas.forEach(k => {
                html += `<li>${k.master_kelas.nama_kelas ?? '(Tanpa Nama)'}</li>`;
            });
            html += '</ul>';
        }

        document.getElementById('kelasContent').innerHTML = html;
        document.getElementById('modalKelas').classList.remove('hidden');
    }
    function tutupModalKelas() {
        document.getElementById('modalKelas').classList.add('hidden');
    }

    @if(old('form_mode') === 'edit' && $errors->any() && old('edit_id'))
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('formEdit').action = `/master/tahunajaran/edit/{{ old('edit_id') }}`;
        document.getElementById('modalEdit').classList.remove('hidden');
        updateTahunAjaranEdit();
    });
    @endif
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Jabatan</title>
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

<h2>Master Jabatan</h2>

<button onclick="bukaModalTambah()">Tambah Jabatan</button>

<form method="GET" action="{{ route('master.jabatan.index') }}" style="margin-top: 10px;">
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
            <th>Jabatan</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Jumlah Karyawan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataJabatan as $index => $jabatan)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $jabatan->nama_jabatan }}</td>
            <td>{{ $jabatan->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td>{{ $jabatan->created_at }}</td>
            <td>{{ $jabatan->updated_at }}</td>
            <td>{{ $jabatan->jabatan_staff_count }} orang</td>
            <td>
                <form action="{{ route('master.jabatan.isActive', $jabatan->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit">{{ $jabatan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                </form>
                <button onclick="bukaModalEdit({{ $jabatan->id }}, '{{ $jabatan->nama_jabatan }}', {{ $jabatan->is_active }})">Edit</button>
                <button onclick="bukaModalKaryawan({{ $jabatan->id }})">Lihat Karyawan</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah -->
<div id="modalTambah" class="{{ old('form_mode') === 'tambah' && $errors->any() ? '' : 'hidden' }}">
    <div class="overlay" onclick="tutupModalTambah()"></div>
    <div class="modal">
        <h3>Tambah Jabatan</h3>
        <form action="{{ route('master.jabatan.add') }}" method="POST">
            @csrf
            <input type="hidden" name="form_mode" value="tambah">
            <label>Nama Jabatan</label><br>
            <input type="text" name="nama_jabatan" value="{{ old('form_mode') === 'tambah' ? old('nama_jabatan') : '' }}" required><br>
            @if(old('form_mode') === 'tambah')
                @error('nama_jabatan')<div style="color:red">{{ $message }}</div>@enderror
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
                <button type="button" onclick="window.location.href='{{ route('master.jabatan.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="{{ old('form_mode') === 'edit' && $errors->any() ? '' : 'hidden' }}">
    <div class="overlay" onclick="tutupModalEdit()"></div>
    <div class="modal">
        <h3>Edit Jabatan</h3>
        <form id="formEdit" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="form_mode" value="edit">
            <input type="hidden" name="edit_id" id="edit_id" value="{{ old('edit_id') }}">
            <label>Nama Jabatan</label><br>
            <input type="text" name="nama_jabatan" id="editNama" value="{{ old('form_mode') === 'edit' ? old('nama_jabatan') : '' }}" required><br>
            @if(old('form_mode') === 'edit')
                @error('nama_jabatan')<div style="color:red">{{ $message }}</div>@enderror
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
                <button type="button" onclick="window.location.href='{{ route('master.jabatan.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Lihat Karyawan -->
<div id="modalKaryawan" class="hidden">
    <div class="overlay" onclick="tutupModalKaryawan()"></div>
    <div class="modal">
        <h3>Daftar Karyawan</h3>
        <div id="karyawanContent">Memuat...</div>
        <div style="margin-top:10px;">
            <button onclick="tutupModalKaryawan()">Tutup</button>
        </div>
    </div>
</div>

<script>
    const daftarJabatan = @json($dataJabatan);

    function bukaModalTambah() {
        document.querySelector('#modalTambah input[name="nama_jabatan"]').value = '';
        document.querySelector('#modalTambah select[name="is_active"]').value = '1';
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function tutupModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function bukaModalEdit(id, nama, isActive) {
        const form = document.getElementById('formEdit');
        form.action = `/master/jabatan/edit/${id}`;
        document.getElementById('edit_id').value = id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editStatus').value = isActive;
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function tutupModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }

    function bukaModalKaryawan(jabatanId) {
        const jabatan = daftarJabatan.find(j => j.id === jabatanId);
        let html = '';

        if (!jabatan || !jabatan.jabatan_staff.length) {
            html = '<p>Tidak ada karyawan.</p>';
        } else {
            html += '<ul>';
            jabatan.jabatan_staff.forEach(js => {
                html += `<li>${js.staff?.nama ?? '(Tanpa Nama)'}</li>`;
            });
            html += '</ul>';
        }

        document.getElementById('karyawanContent').innerHTML = html;
        document.getElementById('modalKaryawan').classList.remove('hidden');
    }

    function tutupModalKaryawan() {
        document.getElementById('modalKaryawan').classList.add('hidden');
    }

    @if(old('form_mode') === 'edit' && $errors->any() && old('edit_id'))
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('formEdit').action = `/master/jabatan/edit/{{ old('edit_id') }}`;
        document.getElementById('modalEdit').classList.remove('hidden');
    });
    @endif
</script>
</body>
</html>

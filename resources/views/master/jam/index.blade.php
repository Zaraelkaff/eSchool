<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Jam Pelajaran</title>
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
<h2>Master Jam Pelajaran</h2>

<button onclick="bukaModalTambah()">Tambah Jam Pelajaran</button>

<form method="GET" action="{{ route('master.jam.index') }}" style="margin-top: 10px;">
    <label for="filter">Filter Status:</label>
    <select name="filter" id="filter" onchange="this.form.submit()">
        <option value="aktif" {{ $filter === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ $filter === 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="semua" {{ $filter === 'semua' ? 'selected' : '' }}>Semua</option>
    </select>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataJam as $index => $jam)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $jam->jam_mulai->format('H:i') }}</td>
            <td>{{ $jam->jam_selesai->format('H:i') }}</td>
            <td>{{ $jam->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td>{{ $jam->created_at }}</td>
            <td>{{ $jam->updated_at }}</td>
            <td>
                <form action="{{ route('master.jam.isActive', $jam->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit">{{ $jam->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                </form>
                <button onclick="bukaModalEdit({{ $jam->id }}, '{{ date('H:i', strtotime($jam->jam_mulai)) }}', '{{ date('H:i', strtotime($jam->jam_selesai)) }}', {{ $jam->is_active ? 1 : 0 }})">Edit</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah -->
<div id="modalTambah" class="{{ old('form_mode') === 'tambah' && $errors->any() ? '' : 'hidden' }}">
    <div class="overlay" onclick="tutupModalTambah()"></div>
    <div class="modal">
        <h3>Tambah Jam Pelajaran</h3>
        <form action="{{ route('master.jam.add') }}" method="POST">
            @csrf
            <input type="hidden" name="form_mode" value="tambah">
            <label>Jam Mulai</label><br>
            <input type="time" name="jam_mulai" value="{{ old('form_mode') === 'tambah' ? old('jam_mulai') : '' }}" required><br>
            @if(old('form_mode') === 'tambah')
                @error('jam_mulai')<div style="color:red">{{ $message }}</div>@enderror
            @endif

            <label>Jam Selesai</label><br>
            <input type="time" name="jam_selesai" value="{{ old('form_mode') === 'tambah' ? old('jam_selesai') : '' }}" required><br>
            @if(old('form_mode') === 'tambah')
                @error('jam_selesai')<div style="color:red">{{ $message }}</div>@enderror
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
                <button type="button" onclick="window.location.href='{{ route('master.jam.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="{{ old('form_mode') === 'edit' && $errors->any() ? '' : 'hidden' }}">
    <div class="overlay" onclick="tutupModalEdit()"></div>
    <div class="modal">
        <h3>Edit Jam Pelajaran</h3>
        <form id="formEdit" method="POST" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="form_mode" value="edit">
            <input type="hidden" name="edit_id" id="edit_id" value="{{ old('edit_id', '') }}">
            <label>Jam Mulai</label><br>
            <input type="time" name="jam_mulai" id="editJamMulai" value="{{ old('jam_mulai', '') }}" required><br>
            @error('jam_mulai')<div style="color:red">{{ $message }}</div>@enderror

            <label>Jam Selesai</label><br>
            <input type="time" name="jam_selesai" id="editJamSelesai" value="{{ old('jam_selesai', '') }}" required><br>
            @error('jam_selesai')<div style="color:red">{{ $message }}</div>@enderror

            <label>Status</label><br>
            <select name="is_active" id="editStatus" required>
                <option value="1" {{ old('form_mode') === 'edit' ? (old('is_active') == '1' ? 'selected' : '') : '' }}>Aktif</option>
                <option value="0" {{ old('form_mode') === 'edit' ? (old('is_active') == '0' ? 'selected' : '') : '' }}>Nonaktif</option>
            </select><br>
            @error('is_active')<div style="color:red">{{ $message }}</div>@enderror

            <div style="margin-top:10px;">
                <button type="submit">Update</button>
                <button type="button" onclick="window.location.href='{{ route('master.jam.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalTambah() {
        document.querySelector('#modalTambah input[name="jam_mulai"]').value = '';
        document.querySelector('#modalTambah input[name="jam_selesai"]').value = '';
        document.querySelector('#modalTambah select[name="is_active"]').value = '1';
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function tutupModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function bukaModalEdit(id, jamMulai, jamSelesai, isActive) {
        const form = document.getElementById('formEdit');
        form.action = `/master/jam/edit/${id}`;
        document.getElementById('edit_id').value = id;
        document.getElementById('editJamMulai').value = jamMulai;
        document.getElementById('editJamSelesai').value = jamSelesai;
        document.getElementById('editStatus').value = isActive;
        console.log('Jam Mulai:', jamMulai, 'Jam Selesai:', jamSelesai, 'Status:', isActive); // Debugging
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function tutupModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }

    @if(old('form_mode') === 'edit' && $errors->any() && old('edit_id'))
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formEdit');
        form.action = `/master/jam/edit/{{ old('edit_id') }}`;
        document.getElementById('modalEdit').classList.remove('hidden');
    });
    @endif
</script>
</body>
</html>
<!-- Staff Edit Form -->
<form action="{{ route('staff.edit', $staff->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div>
        <label for="NIK">NIK</label>
        <input type="text" name="NIK" id="NIK" value="{{ $staff->NIK }}" required>
        @error('NIK')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" value="{{ $staff->nama }}" required>
        @error('nama')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" id="gelar_depan" value="{{ $staff->gelar_depan }}">
        @error('gelar_depan')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="gelar_belakang">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" id="gelar_belakang" value="{{ $staff->gelar_belakang }}">
        @error('gelar_belakang')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label>Jenis Kelamin</label>
        <div>
            <input type="radio" name="jenis_kelamin" id="L" value="L" {{ $staff->jenis_kelamin == 'L' ? 'checked' : '' }}>
            <label for="L">Laki-laki</label>
        </div>
        <div>
            <input type="radio" name="jenis_kelamin" id="P" value="P" {{ $staff->jenis_kelamin == 'P' ? 'checked' : '' }}>
            <label for="P">Perempuan</label>
        </div>
        @error('jenis_kelamin')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_lahir" value="{{ $staff->tgl_lahir }}" required>
        @error('tgl_lahir')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" required>{{ $staff->alamat }}</textarea>
        @error('alamat')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="notelp">No. Telepon</label>
        <input type="text" name="notelp" id="notelp" value="{{ $staff->notelp }}" required>
        @error('notelp')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="lulusan">Lulusan</label>
        <input type="text" name="lulusan" id="lulusan" value="{{ $staff->lulusan }}" required>
        @error('lulusan')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_masuk">Tanggal Masuk</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_masuk" id="tgl_masuk" value="{{ $staff->tgl_masuk }}" required>
        @error('tgl_masuk')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_keluar">Tanggal Keluar</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_keluar" id="tgl_keluar" value="{{ $staff->tgl_keluar }}">
        @error('tgl_keluar')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Simpan Staff</button>
    <a href="{{ route('staff.index') }}">Batal</a>
</form>


<h2>Riwayat Jabatan</h2>
<form action="{{ route('staff.jabatan.add', $staff->id) }}" method="POST" id="add-jabatan-form">
    @csrf
    <div>
        <select name="jabatan_id" required>
            <option value="">Pilih Jabatan</option>
            @foreach($jabatan as $j)
                <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
            @endforeach
        </select>
        Tanggal mulai <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required>
        Tanggal selesai <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}">
        status aktif <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
        <button type="submit">Tambah Jabatan</button>
    </div>
    @error('jabatan_id')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    @error('tgl_mulai')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    @error('tgl_selesai')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</form>

<table>
    <thead>
        <tr>
            <th>Jabatan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staff->jabatan_staff as $js)
            <tr id="row-{{ $js->id }}">
                <td class="jabatan-cell">
                    <span class="display">{{ $js->jabatan->nama_jabatan }}</span>
                    <select name="jabatan_id" class="edit-field" style="display: none;">
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ $js->jabatan_id == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="tgl-mulai-cell">
                    <span class="display">{{ $js->tgl_mulai }}</span>
                    <input type="date" name="tgl_mulai" class="edit-field" style="display: none;" value="{{ $js->tgl_mulai }}">
                </td>
                <td class="tgl-selesai-cell">
                    <span class="display">{{ $js->tgl_selesai ?? '' }}</span>
                    <input type="date" name="tgl_selesai" class="edit-field" style="display: none;" value="{{ $js->tgl_selesai }}">
                </td>
                <td class="status-cell">
                    <span class="display">{{ $js->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    <input type="checkbox" name="is_active" class="edit-field" style="display: none;" value="1" {{ $js->is_active ? 'checked' : '' }}>
                </td>
                <td>
                    <button type="button" class="edit-btn" onclick="toggleEdit({{ $js->id }})">Edit</button>
                    <button type="button" class="cancel-btn" onclick="cancelEdit({{ $js->id }})" style="display: none;">Batal</button>
                    <button type="button" class="delete-btn" onclick="deleteJabatan({{ $staff->id }}, {{ $js->id }})">Hapus</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    function toggleEdit(jabatanStaffId) {
        const row = document.getElementById(`row-${jabatanStaffId}`);
        const editButton = row.querySelector('.edit-btn');
        const cancelButton = row.querySelector('.cancel-btn');
        const isEditing = editButton.textContent === 'Simpan';

        if (isEditing) {
            const jabatanSelect = row.querySelector('.jabatan-cell select[name="jabatan_id"]');
            const tglMulaiInput = row.querySelector('.tgl-mulai-cell input[name="tgl_mulai"]');
            const tglSelesaiInput = row.querySelector('.tgl-selesai-cell input[name="tgl_selesai"]');
            const isActiveInput = row.querySelector('.status-cell input[name="is_active"]');

            const formData = new FormData();
            formData.append('_method', 'PATCH');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('jabatan_id', jabatanSelect.value);
            formData.append('tgl_mulai', tglMulaiInput.value);
            formData.append('tgl_selesai', tglSelesaiInput.value || '');
            formData.append('is_active', isActiveInput.checked ? 1 : 0);

            fetch(`{{ url('staff') }}/{{ $staff->id }}/jabatan/${jabatanStaffId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    const jabatanDisplay = row.querySelector('.jabatan-cell .display');
                    const tglMulaiDisplay = row.querySelector('.tgl-mulai-cell .display');
                    const tglSelesaiDisplay = row.querySelector('.tgl-selesai-cell .display');
                    const isActiveDisplay = row.querySelector('.status-cell .display');

                    if (jabatanDisplay && tglMulaiDisplay && tglSelesaiDisplay && isActiveDisplay) {
                        jabatanDisplay.textContent = jabatanSelect.options[jabatanSelect.selectedIndex].text;
                        tglMulaiDisplay.textContent = tglMulaiInput.value;
                        tglSelesaiDisplay.textContent = tglSelesaiInput.value || '';
                        isActiveDisplay.textContent = isActiveInput.checked ? 'Aktif' : 'Nonaktif';

                        // Toggle back to display mode
                        row.querySelectorAll('.display').forEach(el => el.style.display = 'block');
                        row.querySelectorAll('.edit-field').forEach(el => el.style.display = 'none');
                        editButton.textContent = 'Edit';
                        cancelButton.style.display = 'none';
                        alert('Jabatan berhasil diperbarui');
                    } else {
                        console.error('Missing display elements:', {
                            jabatanDisplay: !!jabatanDisplay,
                            tglMulaiDisplay: !!tglMulaiDisplay,
                            tglSelesaiDisplay: !!tglSelesaiDisplay,
                            isActiveDisplay: !!isActiveDisplay
                        });
                        alert('Terjadi kesalahan: Elemen tampilan tidak ditemukan');
                    }
                } else {
                    alert('Gagal menyimpan: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        } else {
            // Enter edit mode
            row.querySelectorAll('.display').forEach(el => el.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(el => el.style.display = 'block');
            editButton.textContent = 'Simpan';
            cancelButton.style.display = 'inline-block';
        }
    }

    function cancelEdit(jabatanStaffId) {
        const row = document.getElementById(`row-${jabatanStaffId}`);
        const editButton = row.querySelector('.edit-btn');
        const cancelButton = row.querySelector('.cancel-btn');

        // Revert to display mode without saving
        row.querySelectorAll('.display').forEach(el => el.style.display = 'block');
        row.querySelectorAll('.edit-field').forEach(el => el.style.display = 'none');
        editButton.textContent = 'Edit';
        cancelButton.style.display = 'none';
    }

    function deleteJabatan(staffId, jabatanStaffId) {
        if (confirm('Yakin ingin menghapus jabatan ini?')) {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', '{{ csrf_token() }}');

            fetch(`{{ url('staff') }}/${staffId}/jabatan/${jabatanStaffId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Delete response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Delete response data:', data);
                if (data.success) {
                    const row = document.getElementById(`row-${jabatanStaffId}`);
                    if (row) {
                        row.remove();
                        alert('Jabatan berhasil dihapus');
                    } else {
                        console.error('Row not found:', `row-${jabatanStaffId}`);
                        alert('Terjadi kesalahan: Baris tidak ditemukan');
                    }
                } else {
                    alert('Gagal menghapus: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        }
    }
</script>
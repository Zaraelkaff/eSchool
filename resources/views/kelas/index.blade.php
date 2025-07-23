<h2>Daftar Kelas</h2>

<form method="GET" action="{{ route('kelas.index') }}" style="margin-top: 10px;">
    <label for="filter_active">Filter Status:</label>
    <select name="filter_active" id="filter_active" onchange="this.form.submit()">
        <option value="aktif" {{ (isset($filter_active) && $filter_active === 'aktif') ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ (isset($filter_active) && $filter_active === 'nonaktif') ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="semua" {{ (isset($filter_active) && $filter_active === 'semua') ? 'selected' : '' }}>Semua</option>
    </select>
</form>

<button onclick="openTambahModal()" style="margin-top: 15px;">+ Tambah Kelas</button>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top: 10px;">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Jumlah Murid</th>
            <th>Wali Kelas</th>
            <th>Status</th>
            <th>aksi</th>
        </tr>    
    </thead>
    <tbody>
        @foreach($dataKelas as $index => $kelas)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kelas->master_kelas->nama_kelas }}</td>
            <td>{{ $kelas->tahun_ajaran->tahun_ajaran }}</td>
            <td>{{ $kelas->murid->count() }}</td>
            <td>{{ $kelas->walikelas->nama }}</td>
            <td>{{ $kelas->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td>
                <a href="{{ route('kelas.editView', $kelas->id) }}">edit</a>
                <a href="{{ route('kelas.detail', $kelas->id) }}">detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="modalTambah" style="display: none; position: fixed; top: 0; left: 0; 
    width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div style="background: white; padding: 20px; width: 400px; margin: 100px auto; position: relative;">
        <h3>Tambah Kelas</h3>

        @if ($errors->has('kombinasi'))
            <div class="alert alert-danger">{{ $errors->first('kombinasi') }}</div>
        @endif

        <form method="POST" action="{{ route('kelas.add') }}">
            @csrf

            <!-- Field Nama Kelas -->
            <label for="master_kelas_id">Nama Kelas:</label><br>
            <select name="master_kelas_id" required>
                <option value="">-- Pilih --</option>
                @foreach($masterKelas as $mk)
                    <option value="{{ $mk->id }}" {{ old('master_kelas_id') == $mk->id ? 'selected' : '' }}>
                        {{ $mk->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('master_kelas_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br><br>

            <!-- Field Tahun Ajaran -->
            <label for="tahun_ajaran_id">Tahun Ajaran:</label><br>
            <select name="tahun_ajaran_id" required>
                <option value="">-- Pilih --</option>
                @foreach($tahunAjaran as $ta)
                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                        {{ $ta->tahun_ajaran }}
                    </option>
                @endforeach
            </select>
            @error('tahun_ajaran_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br><br>

            <!-- Field Wali Kelas -->
            <label for="wali_kelas_id">Wali Kelas:</label><br>
            <select name="wali_kelas_id" required>
                <option value="">-- Pilih --</option>
                @foreach($waliKelas as $wk)
                    <option value="{{ $wk->id }}" {{ old('wali_kelas_id') == $wk->id ? 'selected' : '' }}>
                        {{ $wk->nama }}
                    </option>
                @endforeach
            </select>
            @error('wali_kelas_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br><br>

            <!-- Field Status -->
            <label for="is_active">Status:</label><br>
            <select name="is_active" required>
                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('is_active')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br><br>

            <button type="submit">Simpan</button>
            <button type="button" onclick="closeTambahModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openTambahModal() {
        document.getElementById('modalTambah').style.display = 'block';
    }
    function closeTambahModal() {
        document.getElementById('modalTambah').style.display = 'none';
    }
    @if ($errors->any())
        openTambahModal();
    @endif  
</script>

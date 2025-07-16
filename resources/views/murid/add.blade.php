<form action="{{ route('murid.add') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>NIK</label>
        <input type="text" name="NIK" class="form-control" required>
        @error('NIK')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>NIS</label>
        <input type="text" name="NIS" class="form-control" required>
        @error('NIS')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-control" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" class="form-control" required>
        @error('tgl_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Agama</label>
        <input type="text" name="agama" class="form-control" required>
        @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" rows="2" required></textarea>
        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>No. Telepon</label>
        <input type="text" name="notelp" class="form-control" required>
        @error('notelp')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Nama Ayah</label>
        <input type="text" name="nama_ayah" class="form-control" required>
        @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Nama Ibu</label>
        <input type="text" name="nama_ibu" class="form-control" required>
        @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Masuk</label>
        <input type="date" name="tgl_masuk" class="form-control" required>
        @error('tgl_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Keluar</label>
        <input type="date" name="tgl_keluar" class="form-control">
        @error('tgl_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="kelas_id" class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
        <select name="kelas_id" id="kelas_id"
            class="form-select @error('kelas_id') is-invalid @enderror" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}">
                {{ $k->master_kelas->nama_kelas ?? 'Nama Kelas Kosong' }} -
                {{ $k->tahun_ajaran->tahun_ajaran ?? 'Tahun Ajaran Kosong' }}
            </option>
            @endforeach
        </select>
        @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Status Aktif</label>
        <select name="is_active" class="form-control" required>
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>
        @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
</form>
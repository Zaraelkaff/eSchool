<form action="{{ route('staff.add') }}" method="POST">
    @csrf

    <div>
        <label for="NIK">NIK</label>
        <input type="text" name="NIK" id="NIK" value="{{ old('NIK') }}" maxlength="16" required>
        @error('NIK')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required>
        @error('nama')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" id="gelar_depan" value="{{ old('gelar_depan') }}">
        @error('gelar_depan')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="gelar_belakang">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" id="gelar_belakang" value="{{ old('gelar_belakang') }}">
        @error('gelar_belakang')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label>Jenis Kelamin</label><br>
        <div>
            <input type="radio" name="jenis_kelamin" id="L" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
            <label for="L">Laki-laki</label>
        </div>
        <div>
            <input type="radio" name="jenis_kelamin" id="P" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
            <label for="P">Perempuan</label>
        </div>
        @error('jenis_kelamin')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
        @error('tgl_lahir')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" required>{{ old('alamat') }}</textarea>
        @error('alamat')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="notelp">No. Telepon</label>
        <input type="text" name="notelp" id="notelp" value="{{ old('notelp') }}" required>
        @error('notelp')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="lulusan">Lulusan</label>
        <input type="text" name="lulusan" id="lulusan" value="{{ old('lulusan') }}" required>
        @error('lulusan')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_masuk" >Tanggal Masuk</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_masuk" id="tgl_masuk" value="{{ old('tgl_masuk') }}" required>
        @error('tgl_masuk')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_keluar">Tanggal Keluar</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_keluar" id="tgl_keluar" value="{{ old('tgl_keluar') }}">
        @error('tgl_keluar')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <hr>
    <h2>Jabatan</h2>

    <div>
        <label for="jabatan_id" class="form-label">Pilih Jabatan</label>
        <select name="jabatan_id" id="jabatan_id"
            class="form-select @error('jabatan_id') is-invalid @enderror" required>
            <option value="">-- Pilih Jabatan --</option>
            @foreach($jabatan as $jabatan)
            <option value="{{ $jabatan->id }}">
                {{ $jabatan->nama_jabatan ?? 'Nama Kelas Kosong' }}
            </option>
            @endforeach
        </select>
        @error('jabatan_id')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_mulai">Tanggal Mulai Jabatan</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_mulai" id="tgl_mulai" value="{{ old('tgl_mulai') }}" required>
        @error('tgl_mulai')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="tgl_selesai">Tanggal Selesai Jabatan</label>
        <input type="date" max="{{ date('Y-m-d') }}" name="tgl_selesai" id="tgl_selesai" value="{{ old('tgl_selesai') }}">
        @error('tgl_selesai')
            <div>{{ $message }}</div>
        @enderror
    </div>
    <br>
    <button type="submit">Simpan</button>
    <a href="{{ route('staff.index') }}">Batal</a>
</form>
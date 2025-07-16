<form action="{{ route('murid.edit', $murid->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label>NIK</label>
        <input type="text" name="NIK" class="form-control" value="{{ $murid->NIK }}" required>
        @error('NIK')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>NIS</label>
        <input type="text" name="NIS" class="form-control" value="{{ $murid->NIS }}" required>
        @error('NIS')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ $murid->nama }}" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-control" required>
            <option value="L" {{ $murid->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ $murid->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" class="form-control" value="{{ $murid->tgl_lahir }}" required>
        @error('tgl_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Agama</label>
        <input type="text" name="agama" class="form-control" value="{{ $murid->agama }}" required>
        @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required>{{ $murid->alamat }}</textarea>
        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>No. Telepon</label>
        <input type="text" name="notelp" class="form-control" value="{{ $murid->notelp }}" required>
        @error('notelp')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Nama Ayah</label>
        <input type="text" name="nama_ayah" class="form-control" value="{{ $murid->nama_ayah }}" required>
        @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Nama Ibu</label>
        <input type="text" name="nama_ibu" class="form-control" value="{{ $murid->nama_ibu }}" required>
        @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Masuk</label>
        <input type="date" name="tgl_masuk" class="form-control" value="{{ $murid->tgl_masuk }}" required>
        @error('tgl_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Keluar</label>
        <input type="date" name="tgl_keluar" class="form-control" value="{{ $murid->tgl_keluar }}">
        @error('tgl_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label>Status Aktif</label>
        <select name="is_active" class="form-control" required>
            <option value="1" {{ $murid->is_active == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $murid->is_active == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
        @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('murid.index') }}" class="btn btn-secondary">Batal</a>
</form>

<h5>Riwayat Kelas Murid</h5>
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<ul class="list-group mb-3">
    @foreach($murid->kelasMurid as $km)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $km->kelas->master_kelas->nama_kelas ?? '-' }} - {{ $km->kelas->tahun_ajaran->tahun_ajaran ?? '-' }}
            <form action="{{ route('murid.kelas.delete', $km->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">delete</button>
            </form>
        </li>
    @endforeach
</ul>

<form method="POST" action="{{ route('murid.kelas.add') }}">
    @csrf
    <input type="hidden" name="murid_id" value="{{ $murid->id }}">

    <div class="input-group mb-3">
        <select name="kelas_id" class="form-select" required>
            <option value="">-- Pilih Kelas Baru --</option>
            @foreach($kelas as $k)
                @php
                    $sudahDiambil = $murid->kelasMurid->contains(function ($item) use ($k) {
                        return $item->kelas_id == $k->id;
                    });
                @endphp
                <option value="{{ $k->id }}" {{ $sudahDiambil ? 'disabled' : '' }}>
                    {{ $k->master_kelas->nama_kelas ?? '-' }} - {{ $k->tahun_ajaran->tahun_ajaran ?? '-' }}
                    {{ $sudahDiambil ? '(Sudah Diambil)' : '' }}
                </option>
            @endforeach
        </select>
        <button class="btn btn-primary" type="submit"><i class="bi bi-plus-circle"></i> Tambah Kelas</button>
    </div>
</form>
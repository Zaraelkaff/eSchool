<h1>Tambah Pengumuman</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengumuman.add') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="judul">Judul:</label><br>
    <input type="text" name="judul" id="judul" value="{{ old('judul') }}"><br><br>
    
    <label for="tgl_publish">Tanggal Publish</label>
    <input type='date' name='tgl_publish' id='tgl_publish'></input><br><br>

    <label for="isi">Isi:</label><br>
    <textarea name="isi" id="isi" rows="4">{{ old('isi') }}</textarea><br><br>

    <label for="flyer">Flyer (opsional):</label><br>
    <input type="file" name="flyer" id="flyer" accept="image/*"><br><br>

    <label for="is_active">Status:</label><br>
    <select name="is_active" id="is_active">
        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="{{ route('pengumuman.index') }}">Kembali ke daftar</a>
<h1>Edit Pengumuman</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengumuman.edit', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <label for="judul">Judul:</label><br>
    <input type="text" name="judul" id="judul" value="{{ old('judul', $pengumuman->judul) }}"><br><br>

    <label for="isi">Isi:</label><br>
    <textarea name="isi" id="isi" rows="4">{{ old('isi', $pengumuman->isi) }}</textarea><br><br>

    <label for="tgl_publish">Tanggal Publish:</label><br>
    <input type="date" name="tgl_publish" id="tgl_publish" value="{{ old('tgl_publish', $pengumuman->tgl_publish) }}"><br><br>

    <label for="flyer">Flyer (opsional):</label><br>
    @if ($pengumuman->flyer)
        <img src="{{ asset('storage/flyer/' . $pengumuman->flyer) }}" alt="Flyer" width="200"><br>
    @endif
    <input type="file" name="flyer" id="flyer" accept="image/*"><br><br>

    <label for="is_active">Status:</label><br>
    <select name="is_active" id="is_active">
        <option value="1" {{ old('is_active', $pengumuman->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('is_active', $pengumuman->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('pengumuman.index') }}">Kembali ke daftar</a>
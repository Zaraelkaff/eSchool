<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Materi {{ $kelasMapel->mapel->nama_mapel }}, Kelas {{ $kelasMapel->kelas->master_kelas->nama_kelas }} - {{ $kelasMapel->kelas->tahun_ajaran->tahun_ajaran }}</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMateriModal">Tambah Materi</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach ($materi as $item)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <span id="judul-{{ $item->id }}">{{ $item->judul }}</span>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="{{ $item->id }}" data-field="judul">Edit</button>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addSubMateriModal" data-materi-id="{{ $item->id }}">Tambah Sub-Materi</button>
                        <form action="{{ route('materi.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus materi ini? Sub-materi juga akan terhapus.')">Hapus</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <p>Pertemuan: <span id="pertemuan-{{ $item->id }}">{{ $item->pertemuan }}</span>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="{{ $item->id }}" data-field="pertemuan">Edit</button>
                    </p>
                    <p>Deskripsi: <span id="deskripsi-{{ $item->id }}">{{ $item->deskripsi }}</span>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="{{ $item->id }}" data-field="deskripsi">Edit</button>
                    </p>
                    <h5>Sub-Materi</h5>
                    <ul class="list-group">
                        @foreach ($item->sub_materi as $sub)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span id="subjudul-{{ $sub->id }}">{{ $sub->subjudul }}</span>
                                    <button class="btn btn-sm btn-outline-primary edit-sub-btn" data-id="{{ $sub->id }}" data-field="subjudul">Edit</button>
                                    <br>
                                    <span id="deskripsi-sub-{{ $sub->id }}">{{ $sub->deskripsi }}</span>
                                    <button class="btn btn-sm btn-outline-primary edit-sub-btn" data-id="{{ $sub->id }}" data-field="deskripsi">Edit</button>
                                    @if ($sub->file)
                                        <br><a href="{{ asset('storage/' . $sub->file) }}" target="_blank">Lihat File</a>
                                    @endif
                                </div>
                                <form action="{{ route('submateri.destroy', $sub->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus sub-materi ini?')">Hapus</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Tambah Materi -->
    <div class="modal fade" id="addMateriModal" tabindex="-1" aria-labelledby="addMateriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMateriModalLabel">Tambah Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('materi.store', $kelasMapel->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pertemuan" class="form-label">Pertemuan</label>
                            <input type="number" class="form-control @error('pertemuan') is-invalid @enderror" id="pertemuan" name="pertemuan" value="{{ old('pertemuan') }}" required>
                            @error('pertemuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Sub-Materi -->
    <div class="modal fade" id="addSubMateriModal" tabindex="-1" aria-labelledby="addSubMateriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubMateriModalLabel">Tambah Sub-Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="subMateriForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subjudul" class="form-label">Subjudul</label>
                            <input type="text" class="form-control @error('subjudul') is-invalid @enderror" id="subjudul" name="subjudul" value="{{ old('subjudul') }}" required>
                            @error('subjudul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_sub" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi_sub" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Buka modal kembali jika ada error validasi
        @if ($errors->has('pertemuan') || $errors->has('judul') || $errors->has('deskripsi'))
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('addMateriModal'));
                modal.show();
            });
        @endif
        @if ($errors->has('subjudul') || $errors->has('deskripsi') || $errors->has('file'))
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('addSubMateriModal'));
                modal.show();
            });
        @endif

        // Reset form dan hapus semua isi saat modal ditutup
        document.getElementById('addMateriModal').addEventListener('hidden.bs.modal', function () {
            const form = this.querySelector('form');
            form.reset();
            form.querySelectorAll('input, textarea').forEach(input => input.value = '');
            this.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        });
        document.getElementById('addSubMateriModal').addEventListener('hidden.bs.modal', function () {
            const form = this.querySelector('form');
            form.reset();
            form.querySelectorAll('input, textarea').forEach(input => input.value = '');
            this.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        });

        // Set action URL for sub-materi form dynamically
        document.querySelectorAll('[data-bs-target="#addSubMateriModal"]').forEach(button => {
            button.addEventListener('click', function () {
                const materiId = this.getAttribute('data-materi-id');
                const form = document.getElementById('subMateriForm');
                form.action = `/materi/${materiId}/submateri`;
                form.reset(); // Reset form saat modal dibuka
                form.querySelectorAll('input, textarea').forEach(input => input.value = '');
            });
        });

        // Edit inline untuk materi
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const field = this.getAttribute('data-field');
                const span = document.getElementById(`${field}-${id}`);
                const value = span.textContent;

                if (this.textContent === 'Edit') {
                    // Ganti span dengan input
                    const inputType = field === 'pertemuan' ? 'number' : 'text';
                    span.innerHTML = `<input type="${inputType}" id="input-${field}-${id}" value="${value}" class="form-control d-inline w-auto">`;
                    this.textContent = 'Simpan';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-success');

                    // Simpan nilai asli untuk batal
                    this.dataset.originalValue = value;
                } else {
                    // Simpan perubahan
                    const newValue = document.getElementById(`input-${field}-${id}`).value;
                    fetch(`/materi/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ [field]: newValue }),
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memperbarui materi');
                        return response.json();
                    })
                    .then(data => {
                        span.textContent = newValue;
                        this.textContent = 'Edit';
                        this.classList.remove('btn-success');
                        this.classList.add('btn-outline-primary');
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui materi.');
                    });
                }
            });
        });

        // Edit inline untuk sub-materi
        document.querySelectorAll('.edit-sub-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const field = this.getAttribute('data-field');
                const span = document.getElementById(`${field}-${id}`);
                const value = span.textContent;

                if (this.textContent === 'Edit') {
                    // Ganti span dengan input
                    span.innerHTML = `<input type="text" id="input-${field}-${id}" value="${value}" class="form-control d-inline w-auto">`;
                    this.textContent = 'Simpan';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-success');

                    // Simpan nilai asli untuk batal
                    this.dataset.originalValue = value;
                } else {
                    // Simpan perubahan
                    const newValue = document.getElementById(`input-${field}-${id}`).value;
                    fetch(`/submateri/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ [field]: newValue }),
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memperbarui sub-materi');
                        return response.json();
                    })
                    .then(data => {
                        span.textContent = newValue;
                        this.textContent = 'Edit';
                        this.classList.remove('btn-success');
                        this.classList.add('btn-outline-primary');
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui sub-materi.');
                    });
                }
            });
        });

        // Batal edit inline saat klik di luar input
        document.addEventListener('click', function (event) {
            document.querySelectorAll('.edit-btn, .edit-sub-btn').forEach(button => {
                if (button.textContent === 'Simpan' && !event.target.closest(`#input-${button.dataset.field}-${button.dataset.id}`) && !event.target.closest('.btn-success')) {
                    const id = button.getAttribute('data-id');
                    const field = button.getAttribute('data-field');
                    const span = document.getElementById(`${field}-${id}`);
                    span.textContent = button.dataset.originalValue;
                    button.textContent = 'Edit';
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-primary');
                    delete button.dataset.originalValue;
                }
            });
        });
    </script>
</body>
</html>
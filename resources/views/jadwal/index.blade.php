<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container { margin: 20px; }
        .schedule-table { width: 100%; border-collapse: collapse; }
        .schedule-table th, .schedule-table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: center; 
            vertical-align: middle;
        }
        .schedule-table th { background-color: #f2f2f2; }
        .add-btn, .remove-btn { 
            padding: 5px 10px; 
            cursor: pointer; 
            border-radius: 4px;
        }
        .add-btn { background-color: #28a745; color: white; }
        .remove-btn { background-color: #dc3545; color: white; }
        .modal-content { padding: 20px; }
    </style>
</head>
<body>
<div class="table-container">
    <h1>Jadwal {{ $kelas->master_kelas->nama_kelas }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="schedule-table">
        <thead>
            <tr>
                <th>Jam</th>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                    <th>{{ $hari }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($jam as $j)
                <tr>
                    <td>{{ $j->jam_mulai->format('H:i') }} - {{ $j->jam_selesai->format('H:i') }}</td>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <td>
                            @php
                                $jadwal = $jadwal_data->where('hari', $hari)
                                    ->where('jam_id', $j->id)
                                    ->first();
                            @endphp
                            @if($jadwal)
                                {{ $jadwal->mapel->nama_mapel }}
                                <br>
                                <button class="remove-btn" 
                                    data-jadwal-id="{{ $jadwal->id }}"
                                    onclick="deleteJadwal({{ $jadwal->id }})">
                                    Hapus
                                </button>
                            @else
                                <button class="add-btn" 
                                    data-hari="{{ $hari }}" 
                                    data-jam-id="{{ $j->id }}"
                                    data-kelas-id="{{ $kelas->id }}"
                                    onclick="openAddModal(this)">
                                    Tambah
                                </button>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for adding schedule -->
<div class="modal fade" id="addScheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <h4>Tambah Jadwal</h4>
            <form id="addScheduleForm" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" id="modal_kelas_id">
                <input type="hidden" name="hari" id="modal_hari">
                <input type="hidden" name="jam_id" id="modal_jam_id">
                
                <div class="mb-3">
                    <label for="mapel_id">Mata Pelajaran</label>
                    <select name="mapel_id" id="mapel_id" class="form-select">
                        @foreach($kelas->kelasMapel as $kelasMapel)
                            <option value="{{ $kelasMapel->mapel->id }}">
                                {{ $kelasMapel->mapel->nama_mapel }} - {{ $kelasMapel->pengajar->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openAddModal(button) {
        const hari = button.getAttribute('data-hari');
        const jamId = button.getAttribute('data-jam-id');
        const kelasId = button.getAttribute('data-kelas-id');

        document.getElementById('modal_hari').value = hari;
        document.getElementById('modal_jam_id').value = jamId;
        document.getElementById('modal_kelas_id').value = kelasId;

        const modal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
        modal.show();
    }

    document.getElementById('addScheduleForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        try {
            const response = await fetch('{{ route('jadwal.add') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json' // Explicitly request JSON response
                }
            });

            // Log the raw response for debugging
            const responseText = await response.text();
            console.log('Raw response:', responseText);

            // Try parsing as JSON
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                alert('Server returned an invalid response. Please check the console for details.');
                return;
            }

            if (result.success) {
                location.reload();
            } else {
                alert(result.message || 'Gagal menambah jadwal');
            }
        } catch (error) {
            console.error('AJAX error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    async function deleteJadwal(jadwalId) {
        if (!confirm('Yakin ingin menghapus jadwal ini?')) return;

        try {
            const response = await fetch(`/jadwal/${jadwalId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json' // Explicitly request JSON response
                }
            });

            // Log the raw response for debugging
            const responseText = await response.text();
            console.log('Raw response:', responseText);

            // Try parsing as JSON
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                alert('Server returned an invalid response. Please check the console for details.');
                return;
            }

            if (result.success) {
                location.reload();
            } else {
                alert(result.message || 'Gagal menghapus jadwal');
            }
        } catch (error) {
            console.error('AJAX error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        }
    }
</script>
</body>
</html>
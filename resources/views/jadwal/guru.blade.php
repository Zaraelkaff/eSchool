<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Guru</title>
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
    </style>
</head>
<body>
<div class="table-container">
    <h1>Jadwal {{ $guru->nama }}</h1>

    <!-- Filter Tahun Ajaran -->
    <div class="mb-3">
        <label for="tahun_ajaran_id" class="form-label">Pilih Tahun Ajaran</label>
        <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" onchange="this.form.submit()">
            @foreach($tahunAjarans as $tahunAjaran)
                <option value="{{ $tahunAjaran->id }}" {{ $selectedTahunAjaranId == $tahunAjaran->id ? 'selected' : '' }}>
                    {{ $tahunAjaran->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    @if($jadwal_data->isNotEmpty())
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
                @foreach($all_jams as $jam)
                    <tr>
                        <td>{{ $jam->jam_mulai->format('H:i') }} - {{ $jam->jam_selesai->format('H:i') }}</td>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <td>
                                @php
                                    $jadwal = $jadwal_data->where('hari', $hari)
                                        ->where('jam_id', $jam->id)
                                        ->first();
                                @endphp
                                @if($jadwal && $jadwal->kelasMapel)
                                    {{ $jadwal->kelasMapel->mapel->nama_mapel }}<br>
                                    {{ $jadwal->kelasMapel->kelas->master_kelas->nama_kelas }}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada jadwal untuk tahun ajaran yang dipilih.</p>
    @endif
</div>

<form id="filterForm" method="GET" action="{{ route('staff.jadwal', $guru->id) }}">
    @csrf
    <input type="hidden" name="tahun_ajaran_id" id="hidden_tahun_ajaran_id" value="{{ $selectedTahunAjaranId }}">
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('tahun_ajaran_id').addEventListener('change', function() {
        const selectedValue = this.value;
        document.getElementById('hidden_tahun_ajaran_id').value = selectedValue;
        console.log('Submitting form with tahun_ajaran_id:', selectedValue);
        document.getElementById('filterForm').submit();
    });
</script>
</body>
</html>
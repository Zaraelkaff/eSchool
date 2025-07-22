<form method="GET" action="{{ route('staff.index') }}" class="mb-3">
    <label for="filter_active">Filter Status:</label>
    <select name="filter_active" id="filter_active" onchange="this.form.submit()" class="form-select w-auto d-inline">
        <option value="aktif" {{ (isset($filter_active) && $filter_active === 'aktif') ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ (isset($filter_active) && $filter_active === 'nonaktif') ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="semua" {{ (isset($filter_active) && $filter_active === 'semua') ? 'selected' : '' }}>Semua</option>
    </select>
</form>
<a href="{{ route('staff.addView') }}">Tambah Staff</a>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>JK</th>
            <th>No Telp</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataStaff as $index => $staff)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $staff->NIK }}</td>
                <td>{{ $staff->nama }}, {{ $staff->gelar_belakang }}</td>
                <td>{{ $staff->jenis_kelamin }}</td>
                <td>{{ $staff->notelp }}</td>
                <td>{{ $staff->is_active ? 'Aktif' : 'Tidak Aktif'}}</td>
                <td>
                    <a href="{{ route('staff.editView', $staff->id) }}">edit</a>
                    <a href="{{ route('staff.detail', $staff->id) }}">detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
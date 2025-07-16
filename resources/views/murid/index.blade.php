<form method="GET" action="{{ route('murid.index') }}" class="mb-3">
    <label for="filter">Filter Status:</label>
    <select name="filter" id="filter" onchange="this.form.submit()" class="form-select w-auto d-inline">
        <option value="aktif" {{ (isset($filter) && $filter === 'aktif') ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ (isset($filter) && $filter === 'nonaktif') ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="semua" {{ (isset($filter) && $filter === 'semua') ? 'selected' : '' }}>Semua</option>
    </select>
</form>

<a href="{{ route('murid.addView') }}">tambah murid</a>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>JK</th>
            <th>No Telp</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataMurid as $index => $murid)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $murid->NIK }}</td>
                <td>{{ $murid->NIS }}</td>
                <td>{{ $murid->nama }}</td>
                <td>{{ $murid->jenis_kelamin }}</td>
                <td>{{ $murid->notelp }}</td>
                <td>{{ $murid->is_active ? 'Aktif' : 'Tidak Aktif'}}</td>
                <td>
                    <form action="{{ route('murid.isActive', $murid->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="btn btn-action hover-lift {{ $murid->is_active ? 'btn-success' : 'btn-danger' }}"
                            title="{{ $murid->is_active ? 'Set Tidak Aktif' : 'Set Aktif' }}">
                            <i class="bi bi-toggle-{{ $murid->is_active ? 'on' : 'off' }}"></i>
                        </button>
                    </form>
                    <a href="{{ url('/murid/detail/'.$murid->id) }}">detail</a>
                    <a href="{{ route('murid.editView', $murid->id) }}">edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
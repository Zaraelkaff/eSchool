<form method="GET" action="{{ route('pengumuman.index') }}">
    <div>
        <label for="filter">Filter:</label>
        <select name="filter" id="filter" onchange="this.form.submit()" class="form-select" style="width: auto; min-width: 140px;">
            <option value="aktif" {{ (isset($filter) && $filter === 'aktif') ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ (isset($filter) && $filter === 'nonaktif') ? 'selected' : '' }}>Tidak Aktif</option>
            <option value="semua" {{ (isset($filter) && $filter === 'semua') ? 'selected' : '' }}>Semua</option>
        </select>
    </div>
</form>
<a href="{{ route('pengumuman.addView') }}">Tambah Pengumuman</a>
@if($pengumuman->isEmpty())
    <p>Belum ada pengumuman yang tersedia</p>
@else
    @foreach($pengumuman as $p)
        <div>
            <h4>{{ $p->judul }}</h4>
        </div>
        @if($p->flyer)
            <a href="{{ route('pengumuman.detail', $p->id) }}">
                <div>
                    <img src="{{ asset('storage/flyer/' . $p->flyer) }}" alt="Flyer {{ $p->judul }}" loading="lazy">
                </div>
            </a>
        @endif
    @endforeach
@endif
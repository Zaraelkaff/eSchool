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
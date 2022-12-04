@props(['genres'])
<div class="">
    @foreach ($genres as $genre)
        <span class="badge rounded-pill bg-dark">
            <a href="/books/bygenre/{{ $genre->id }}" class="text-light text-decoration-none">{{ $genre->name }}</a>
        </span>
    @endforeach
</div>

@props(['book'])
<x-card>
    <div class="col mx-auto rounded bg-white pb-2">
        <img class="img-fluid rounded-top custom-card"
            src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/empty_book.jpg') }}"
            alt="{{ $book->title }}" />
        <div class="px-3 h-100">
            <h5>
                <a href="/books/{{ $book->id }}"
                    class="text-dark text-decoration-none fw-bold">{{ $book->title }}</a>
            </h5>
            <p class="text-muted text-truncate" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $book->author }}">
                <span class="text-right w-100 text-success fs-5">{{$book->price}}$</span><br />
                {{ $book->author }}
            </p>
            <p class="text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->description }}">
                {{ $book->description }}
            </p>
        </div>
    </div>
</x-card>

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 mt-2 col-md-6">
            <div class="card border-0">
                <img src="{{ asset('images/empty_book.jpg') }}" class="card-img-top" alt="...">
            </div>
        </div>
        <div class="col-lg-6 mt-2 col-md-6">
            <dl>
                <dt>Title</dt>
                <dd>{{ $book->title }}</dd>
                <dt>Price</dt>
                <dd class="fw-bold text-success">{{ $book->price }}$</dd>
                @if (count($book->genres) != 0)
                    <dt>Genres</dt>
                    <dd>
                        <x-book-genres :genres="$book->genres"></x-book-genres>
                    </dd>
                @endif
                <dt>Description</dt>
                <dd>{{ $book->description }}</dd>
                <dt>ISBN</dt>
                <dd>{{ $book->isbn }}</dd>
                <dt>Author</dt>
                <dd>{{ $book->author }}</dd>
                <dt>Pages</dt>
                <dd>{{ $book->pages }}</dd>
                <dt>Released at</dt>
                <dd>
                    @php
                        $date = new DateTimeImmutable($book->released_at);
                        echo $date->format('Y');
                    @endphp
                </dd>
                <dt>Avaliable in stock</dt>
                <dd class="fw-bold">
                    @php
                        echo $book->in_stock == 1 ? "<span class='text-success'>Available</span>" : "<span class='text-danger text-decoration-line-through'>Unavailable</span>";
                    @endphp
                </dd>
            </dl>
            @if (\App\Services\IsAdmin::check(Auth::user()))
                <p>
                    <a href="{{ url('/books/' . $book->id . '/edit') }}" class="btn btn-primary col-md-4" rel="create book">
                        Edit
                    </a>
                <form action="{{ url('/books/' . $book->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete {{ $book->name }} book?')"
                        class="btn btn-outline-danger">Delete</button>
                </form>
                </p>
            @endif
        </div>
    </div>
@endsection

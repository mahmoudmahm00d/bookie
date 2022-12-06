@extends('layouts.app')

@section('content')
    @if (\App\Services\IsAdmin::check(Auth::user()))
        <p>
            <a href="{{ url('/books/create') }}" class="btn btn-primary" rel="create bookk">Create new book</a>
        </p>
    @endif
    <div>
        <form action="{{ url('/') }}" method="GET" class="form">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="query" id="query"
                    placeholder="Search by book title, author, isbn, or genre ...">
                <button type="submit" class="input-group-text btn btn-light border"><svg xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg> &nbsp; Search</button>
            </div>
        </form>
    </div>
    @if (Auth::guest() || \App\Services\IsAdmin::check(Auth::user()))
        <div class="row">
            @foreach ($books as $book)
                <x-book-card :book="$book"></x-book-card>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-md-4">
                <livewire:cart-component />
            </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach ($books as $book)
                        <div class="col-md-6 col-lg-4">
                            <livewire:book-component :book='$book' />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

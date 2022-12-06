@extends('layouts.app')

@section('content')
    @if (\App\Services\IsAdmin::check(Auth::user()))
        <p>
            <a href="{{ url('/books/create') }}"  class="btn btn-primary" rel="create bookk">Create new book</a>
        </p>
    @endif
    <div class="row">
        @foreach ($items as $item)
            <x-book-card :book="$item->book"></x-book-card>
        @endforeach
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <p>
        <a href="/genres/create" class="btn btn-primary">Create</a>
    </p>
    <div class="table-responsive">
        <table
            class="table table-striped
        table-hover	
        table-bordered
        table-light
        align-middle">
            <thead class="table-light">
                <caption>Genres</caption>
                <tr>
                    <th class="col-8">Name</th>
                    <th class="col-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr>
                        <td scope="row">{{ $genre->name }}</td>
                        <td class="d-flex">
                            <a href="/genres/{{ $genre->id }}/edit" class="btn btn-outline-primary">Edit</a> &nbsp; |
                            &nbsp;
                            <form action="{{ url('/genres/' . $genre->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete {{$genre->name}} genre?')" class="btn btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/datatables.min.css') }}" />
@endsection

@section('content')
    <h3>Borrows</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <caption>Borrows</caption>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Started at</th>
                    <th>Deadline</th>
                    <th>Returned at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrows as $borrow)
                    <tr>
                        <td>{{ $borrow->status }}</td>
                        <td>{{ $borrow->started_at }}</td>
                        <td>{{ $borrow->deadline }}</td>
                        <td>{{ $borrow->returned_at }}</td>
                        <td class="d-flex">
                            <a href="/borrows/{{ $borrow->id }}/books" class="btn btn-outline-primary">Books</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('libs/jquery/jquery-3.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>
@endsection

@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/datatables.min.css') }}" />
@endsection

@section('content')
    <h3>Users</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <caption>Users</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td scope="row">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td class="d-flex">
                            <a href="/users/{{ $user->id }}/borrows" class="btn btn-outline-primary">Borrows</a>&nbsp; |
                            &nbsp;
                            <a href="/users/{{ $user->id }}/edit" class="btn btn-outline-primary">Wallet</a>
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

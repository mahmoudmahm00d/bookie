@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/vanillajs-datepicker/css/datepicker-bs5.min.css') }}" />
@endsection

@section('content')
    <h3>Notifications</h3>
    <p>
        <a href="{{ url('/notifications/create') }}" class="btn btn-primary" rel="create bookk">Create new notification</a>
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <caption>Notifications</caption>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <td scope="row">{{ $notification->title }}</td>
                        <td>{{ $notification->body }}</td>
                        <td>{{ $notification->created_at ? date('Y-m-d', strtotime($notification->created_at)) : '' }}</td>
                        </td>
                        <td class="d-flex">
                            <a href="/notifications/{{ $notification->id }}/edit" class="btn btn-outline-primary">Edit</a>
                            &nbsp; |
                            &nbsp;
                            <form action="{{ url('/notifications/' . $notification->id) }}"
                                wire:submit="$emit('notificationDeleted')" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Delete {{ $notification->name }} notification?')"
                                    class="btn btn-outline-danger">Delete</button>
                            </form>
                        </td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('libs/jquery/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>
@endsection

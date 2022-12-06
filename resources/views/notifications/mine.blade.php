@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/vanillajs-datepicker/css/datepicker-bs5.min.css') }}" />
@endsection

@section('content')
    <div class="col-md-6 mx-auto">
        <h3>Notifications</h3>
        @if (count($notifications) == 0)
            You don't have any notifications.
        @else
            @foreach ($notifications as $notification)
                <div class="bg-white rounded p-2 mb-2">
                    <dt clas>{{ $notification->title }}</dt>
                    <dd class="text-truncate"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notification->body }}">{{ $notification->body }}</dd>
                </div>
            @endforeach
        @endif
        {{-- <livewire:notifications-panel></livewire:notifications-panel> --}}
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

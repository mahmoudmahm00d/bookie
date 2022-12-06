@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/vanillajs-datepicker/css/datepicker-bs5.min.css') }}" />
@endsection

@section('content')
    <h3>Borrows</h3>

    <div>
        <form action="{{ url('/borrows') }}" method="GET" class="row row-cols-lg-auto g-3 align-items-center col-md-12 col-lg-8 col-xl-6">
            <div class="col">
                <div class="mb-3">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date"
                        aria-describedby="helpId">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date"
                        aria-describedby="helpId">
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary mb-3">Submit</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <caption>Borrows</caption>
            <thead>
                <tr>
                    <th>User Name</th>
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
                        <td scope="row">{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->status }}</td>
                        <td>{{ $borrow->started_at ? date('Y-m-d', strtotime($borrow->started_at)) : '' }}</td>
                        <td>{{ $borrow->deadline ? date('Y-m-d', strtotime($borrow->deadline)) : '' }}</td>
                        <td>{{ $borrow->returned_at ? date('Y-m-d', strtotime($borrow->returned_at)) : 'Not returned yet.' }}</td>
                        <td class="d-flex">
                            <a href="/borrows/{{ $borrow->id }}/edit" class="btn btn-outline-primary">Edit Status</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('libs/jquery/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('libs/vanillajs-datepicker/js/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
            const from = document.querySelector('input[name="from_date"]');
            const to = document.querySelector('input[name="to_date"]');
            const fromDatepicker = new Datepicker(from, {
                buttonClass: 'btn',
                format: 'yyyy-m-dd',
            });
            const toDatepicker = new Datepicker(to, {
                buttonClass: 'btn',
                format: 'yyyy-m-dd',
            });
        });
    </script>
@endsection

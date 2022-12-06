@extends('layouts.app')

@section('content')
    <div class="col-md-6 mx-auto">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <dl>
            <dt>Borrow start at</dt>
            <dd>{{ $borrow->started_at }}</dd>
            <dt>Your deadline</dt>
            <dd>{{ $borrow->deadline }}</dd>
            <dt>Address</dt>
            <dd>{{ $borrow->address }}</dd>
        </dl>
        <form action="/borrows/{{ $borrow->id }}/pay" method="post" class="col-md-6 needs-validation"
            enctype="multipart/form-data" novalidate>
            @csrf
            <div class="mb-3" id="password-section">
                <label for="password" class="form-label">Your passowrd</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="****">
                @error('password')
                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Pay</button>
        </form>
        <div class="table-responsive mt-5">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <caption>Books</caption>
                    <tr class="bg-light">
                        <th scope="col">Book title</th>
                        <th scope="col">Author</th>
                        <th scope="col">price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="">
                            <td scope="row">{{ $item->book->title }}</td>
                            <td>{{ $item->book->author }}</td>
                            <td>{{ $item->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('libs/jquery/jquery-3.6.1.min.js') }}"></script>
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection

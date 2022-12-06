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
            <dd>{{ \Carbon\Carbon::now()->toDateString() }}</dd>
            <dt>Your deadline</dt>
            <dd>{{ \Carbon\Carbon::now()->addDays(15)->toDateString() }}</dd>
            <dt>Address</dt>
            <dd>{{ $borrow->address }}</dd>
        </dl>
        <form action="/borrows/{{ $borrow->id }}" method="post" class="col-md-6 needs-validation"
            enctype="multipart/form-data" novalidate>
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="status" class="form-label">Payment method</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="WAITING_FOR_PAYMENT">Waiting For Payment</option>
                    <option value="PENDING">Pending</option>
                    <option value="DELIVERING">Delivering</option>
                    <option value="DONE">Done</option>
                </select>
                @error('status')
                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="password-section">
                <label for="password" class="form-label">Your passowrd</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="****">
                @error('password')
                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
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
                    @foreach ($books as $book)
                        <tr class="">
                            <td scope="row">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->price }}</td>
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
        let passwordSection = $('#password-section');
        let paymentType = $('#payment');
        passwordSection.slideUp();

        paymentType.on('change', function(event) {
            let value = event.target.value;
            if (value == 'CASH') {
                console.log('here');
                passwordSection.slideUp();
            } else {
                passwordSection.removeClass('d-none');
                passwordSection.slideDown();
            }
        });

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

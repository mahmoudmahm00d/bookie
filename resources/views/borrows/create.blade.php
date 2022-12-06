@extends('layouts.app')

@section('content')
    <div class="col-md-6 mx-auto">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <livewire:cart-component></livewire:cart-component>
        <dl>
            <dt>Borrow start at</dt>
            <dd>{{ \Carbon\Carbon::now()->toDateString() }}</dd>
            <dt>Your deadline</dt>
            <dd>{{ \Carbon\Carbon::now()->addDays(15)->toDateString() }}</dd>
        </dl>
        <form action="/borrows" method="post" class="col-md-6 needs-validation" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="mb-3">
                <label for="address" class="form-label">Deliver to</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Shipping Address"
                    required>
                @error('address')
                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="payment" class="form-label">Payment method</label>
                <select class="form-select" name="payment" id="payment" required>
                    <option value="CASH">cash</option>
                    <option value="E_PAYMENT">E-Payment</option>
                </select>
                @error('payment')
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
            <button type="submit" class="btn btn-primary">Borrow</button>
        </form>
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

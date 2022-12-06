@extends('layouts.app')

@section('content')
    <h3>Edit user wallet</h3>
    <form action="/users/{{ $user->id }}" method="post" class="col-md-6 needs-validation" novalidate>
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="wallet" class="form-label">Wallet balance</label>
            <input type="text" class="form-control" min="0" name="wallet" id="wallet" placeholder="Wallet" required
                value="{{ $user->wallet }}">
            @error('wallet')
                <p class="text-red text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
@endsection

@section('scripts')
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

@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <h3>Edit notification</h3>
    <form action="/notifications/{{ $notification->id }}" method="post" class="col-md-6 needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Notification title"
                value="{{ $notification->title }}" required>
            @error('title')
                <p class="text-red text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Body</label>
            <input type="text" class="form-control" name="body" id="body" placeholder="Notification body"
                value="{{ $notification->body }}" required>
            @error('body')
                <p class="text-red text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <input type="checkbox" class="form-check-input" name="public" id="public"
                {{ $notification->public == 1 ? 'checked' : '' }} value="false" />
            <label for="public" class="form-label">Public notification</label>
            @error('public')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3" id="users-section">
            <label for="users" class="form-label">Users</label>
            <select class="form-select select2" placeholder="Notification users" name="users[]" id="users"
                size="1" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        @php echo $notification->users->contains($user) ? 'selected' : '' @endphp>{{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('libs/jquery/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
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

        $(document).ready(function() {
            $('.select2').select2({
                'placeholder': 'Notification users',
                'selectionCssClass': 'form-select'
            });

            @php
                if ($notification->public) {
                    echo '$("#users-section").slideUp()';
                }
            @endphp

        $('#public').on('change', function(event) {
            let target = $(event.target);
            if (target.attr('checked')) {
                target.removeAttr('checked')
                $('#users-section').slideDown();
            } else {
                target.attr('checked', '')
                $('#users-section').slideUp();
            }
        });
        });
    </script>
@endsection

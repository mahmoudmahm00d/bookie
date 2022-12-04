@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <form action="/books" method="post" class="col-md-6 needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Book title" required>
            @error('title')
                <p class="text-red text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" name="author" id="author" placeholder="Book author" required>
            @error('author')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Book isbn" required>
            @error('isbn')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" class="form-control" name="description" id="description" placeholder="Book description"
                required></textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" pattern="((^(\d+)(\.?)(\d+)$)|^(\d)$)" class="form-control" name="price" id="price"
                placeholder="Book price" required>
            @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="pages" class="form-label">Pages</label>
            <input type="number" class="form-control" min="1" name="pages" id="pages" placeholder="Book pages"
                required />
            @error('pages')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="released_at" class="form-label">Released at</label>
            <input type="date" class="form-control" name="released_at" id="released_at" placeholder="Book released at"
                required />
            @error('released_at')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <input type="checkbox" class="form-check-input" name="in_stock" id="in_stock" checked=false value="false"/>
            <label for="in_stock" class="form-label">Book in stock</label>
            @error('in_stock')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover image</label>
            <input type="file" class="form-control-file" accept="image/*" name="cover_image" id="cover_image"/>
            @error('cover_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="genres" class="form-label">Genres</label>
            <select class="form-select select2" placeholder="Book genres" name="genres[]" id="genres" size="1"
                multiple>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
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
                'placeholder': 'Book genres',
                'selectionCssClass': 'form-select'
            });
        });
    </script>
@endsection

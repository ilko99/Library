@extends('layouts.library')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Edit Author</h2>

            <form action="{{ route('authors.update', $author->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- This is required for the update method -->

                <div class="mb-3">
                    <label for="name" class="form-label">Author Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $author->name }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Author</button>
                <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection
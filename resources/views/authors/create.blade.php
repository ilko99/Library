@extends('layouts.library')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Add A New Author</h2>

        <form action="{{ route('authors.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="text" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Author</button>
        </form>
    </div>
</div>

@endsection
@extends('layouts.library')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Add New Book</h2>

        <form action="{{ route('books.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="author_id" class="form-label">Author</label>
                <select multiple="multiple" name="authors[]" class="form-control">
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
    </div>
</div>

@endsection
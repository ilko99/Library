@extends('layouts.library')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Edit Book: {{ $book->title }}</h2>

        <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
            </div>

            <select multiple="multiple" name="authors[]" class="form-control">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ in_array($author->id, $selectedAuthors) ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
</div>

@endsection
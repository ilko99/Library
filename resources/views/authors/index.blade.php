@extends('layouts.library')

@section('title', 'Author List')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Authors</h2>
        
        <div class="mb-3">
            <a href="{{ route('authors.create') }}" class="btn btn-primary">Add New Author</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this author?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
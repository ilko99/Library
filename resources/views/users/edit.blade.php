@extends('layouts.library')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Edit User: {{ $user->name }}</h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
            </div>

            @foreach($allBooks as $book)
                <div class="form-check">
                <input class="form-check-input" type="checkbox" name="books[]" value="{{ $book->id }}" 
                    {{ in_array($book->id, $userBookIds) ? 'checked' : '' }}>
                <label class="form-check-label">
                    {{ $book->title }}
                </label>
                 </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</div>

@endsection
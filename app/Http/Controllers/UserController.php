<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $userService;
    protected $bookService;

    public function __construct(UserService $userService, BookService $bookService)
    {
        $this->userService = $userService;
        $this->bookService = $bookService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers()->load('books');
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user = $user->load('books');

        return response()->json($user);
    }


    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10'
        ]);

        $user = $this->userService->createUser($validatedData);

        $user->books()->attach($request->books);

        return response()->json([
            'message' => 'User successfully created and books associated.',
            'user' => $user->load('books')
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|numeric|digits:10'
        ]);

        $user = $this->userService->updateUser($id, $validatedData);

        $user->books()->sync($request->books);

        return response()->json([
            'message' => 'User successfully updated and books associated.',
            'user' => $user->load('books')
        ]);
    }

    public function destroy($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        $this->userService->deleteUser($id);
        
        return response()->json(['message' => 'User successfully deleted and books associated.', 200]);
    }
}

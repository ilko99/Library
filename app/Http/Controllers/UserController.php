<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return  view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return  view('users.show', compact('user'));
    }

    public function create()
    {
        $books = Book::all();
        return view('users.create', compact('books')); 
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10'
        ]);

        $user = $this->userService->createUser($validatedData);

        $bookIds = $request->input('books', []);
        foreach ($bookIds as $bookId) {
            DB::table('user_book')->insert([
                'user_id' => $user->id,
                'book_id' => $bookId
            ]);
        }
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $allBooks = Book::all();
        $userBookIds = DB::table('user_book')->where('user_id', $id)->pluck('book_id')->toArray();
    
        return view('users.edit', compact('user', 'allBooks', 'userBookIds'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|numeric|digits:10'
        ]);

        $this->userService->updateUser($id, $validatedData);

        $bookIds = $request->input('books', []);
        DB::table('user_book')->where('user_id', $id)->delete();
    
        foreach ($bookIds as $bookId) {
            DB::table('user_book')->insert([
                'user_id' => $id,
                'book_id' => $bookId
            ]);
        }
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        DB::table('user_book')->where('user_id', $id)->delete();
        

        $this->userService->deleteUser($id);
        
        return redirect()->route('users.index');
    }
}

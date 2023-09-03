<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\AuthorService;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    protected $bookService;
    protected $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index()
    {   
        $books = $this->bookService->getAllBooks()->load('authors');

        return response()->json($books);
    }

    public function show($id)
    {
        $book = $this->bookService->getBookById($id);

        if(!$book){
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book = $book->load('authors');

        return response()->json($book);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255|unique:books',
            'authors' => 'required|array'
        ]);
    
        $books = $this->bookService->createBook($request->only(['title']));



        $books->authors()->attach($request->authors); // take the authors and attach them to the book by ading them to the pivot table

        return response()->json(['message' => 'Book created successfully', 'book' => $books], 202);
    }


    public function update($id, Request $request)
    {
        $book = $this->bookService->getBookById($id);

        if(!$book){
            return response()->json(['message' => 'Book not found'], 404);
        }

        $this->validate($request, [
            'title' => 'required|string|max:255|unique:books,title,' . $id,
            'authors' => 'required|array'
        ]);

        $this->bookService->updateBook($id, $request->only(['title']));

      
        $book->authors()->sync($request->authors); // can also be a function in the bookService
        
        return response()->json(['message' => 'Book updated successfully', 'data' => $book], 200);
    }

    public function destroy($id)
    {
        $book = $this->bookService->getBookById($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $this->bookService->deleteBook($id);

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}

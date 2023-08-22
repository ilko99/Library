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

    public function __construct(BookService $bookService, AuthorService $authorService){
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index(){
       
        $books = $this->bookService->getAllBooks();
        return view('books.index', compact('books'));
    }

    public function show($id){
        $book = $this->bookService->getBookById($id);
        return view('books.show', compact('book'));
    }


    public function create(){
    
        $authors = $this->authorService->getAllAuthors(); 
        return view('books.create', compact('authors'));
    }

    public function store(Request $request){
  

        $this->validate($request, [
            'title' => 'required|string|max:255|unique:books',
            'authors' => 'required|array'
        ]);
    
        $book = $this->bookService->createBook($request->only(['title']));
        $book->authors()->attach($request->authors); 

        return redirect()->route('books.index');
    }

    public function edit($id){
        $book = $this->bookService->getBookById($id);
        $authors = $this->authorService->getAllAuthors();
        $selectedAuthors = $book->authors->pluck('id')->toArray();
        return view('books.edit', compact('book', 'authors', 'selectedAuthors'));
 
    }

    public function update($id, Request $request){
        $this->validate($request, [
            'title' => 'required|string|max:255|unique:books,title,' . $id,
            'authors' => 'required|array'
        ]);

        $this->bookService->updateBook($id, $request->only(['title']));
        $book = $this->bookService->getBookById($id);
        $book->authors()->sync($request->authors);
        return redirect()->route('books.index');

    }

    public function destroy($id){
        DB::table('author_book')->where('book_id', $id)->delete();

        DB::table('user_book')->where('book_id', $id)->delete();

        $this->bookService->deleteBook($id);

        return redirect()->route('books.index');
    }
}

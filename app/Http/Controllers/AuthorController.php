<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthorService;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService){
        $this->authorService = $authorService;
    }

    public function index(){
        $authors = $this->authorService->getAllAuthors();
        return view('authors.index', compact('authors'));
    }

    public function show($id){
        $author = $this->authorService->getAuthorById($id);
        return  view('authors.show', compact('author'));
    }


    public function create(){
        return view('authors.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:authors'
        ]);
        $this->authorService->createAuthor($request->all());
        return redirect()->route('authors.index');
    }

    public function edit($id){
        $author = $this->authorService->getAuthorById($id);
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
        ]);
        $this->authorService->updateAuthor($id, $request->all());
        return redirect()->route('authors.index');
    }

    public function destroy($id){
        DB::table('author_book')->where('author_id', $id)->delete();

        $this->authorService->deleteAuthor($id);

        return redirect()->route('authors.index');
    }
}

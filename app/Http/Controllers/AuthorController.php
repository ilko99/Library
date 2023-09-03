<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthorService;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        $authors = $this->authorService->getAllAuthors()->load('books');

        return response()->json($authors);
    }

    public function show($id)
    {
        $author = $this->authorService->getAuthorById($id);

        if(!$author){
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author = $author->load('books');

        return response()->json($author);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:authors',
            'books' => 'sometimes|array'
        ]);

        $authors = $this->authorService->createAuthor($request->only('name'));

        if($request->has('books')){
            $authors->books()->attach($request->books);
        }

        return response()->json(['message' => 'Author created successfully', 'author' => $authors], 201);
    }


    public function update(Request $request, $id)
    {
        $author = $this->authorService->getAuthorById($id);

        if(!$author){
            return response()->json(['message' => 'Author not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
            'books' => 'sometimes|array'
        ]);

        $author = $this->authorService->updateAuthor($id, $request->only('name'));

        if($request->has('books')){
            $author->books()->attach($request->books);
        }

        return response()->json(['message' => 'Author updated successfully', 'data' => $author], 200);
    }

    public function destroy($id)
    {
        $author = $this->authorService->getAuthorById($id);

        if(!$author){
            return response()->json(['message' => 'Author not found'], 404);
        }

        $this->authorService->deleteAuthor($id);

        return response()->json(['message' => 'Author deleted successfully'], 200);
    }
}

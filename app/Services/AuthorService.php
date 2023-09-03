<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AuthorRepositoryInterface;

class AuthorService
{
    protected $AuthorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function getAllAuthors()
    {
        return $this->authorRepository->getAll();
    }

    public function getAuthorById($id)
    {
        return $this->authorRepository->find($id);
    }

    public function createAuthor(array $data)
    {
        return $this->authorRepository->create($data);
    }

    public function updateAuthor($id, array $data)
    {
        return $this->authorRepository->update($id, $data);
    }

    public function deleteAuthor($id)
    {
        DB::table('author_book')->where('author_id', $id)->delete();

        return $this->authorRepository->delete($id);
    }

}
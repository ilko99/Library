<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class EloquentBookRepository implements BookRepositoryInterface
{
    protected $model;

    public function __construct(Book $book){
        $this->model = $book;
    }

    public function getAll(){
        return $this->model->all();
    }
    
    public function find($id){
        return $this->model->find($id);
    }
    
    public function create(array $attributes){
        return $this->model->create($attributes);
    }
    
    public function update($id, array $attributes){
        $book = $this->find($id);
        $book->update($attributes);
        return $book;
    }
    
    public function delete($id){
        return $this->model->destroy($id);
    }
    
}
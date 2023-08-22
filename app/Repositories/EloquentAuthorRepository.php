<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;

class EloquentAuthorRepository implements AuthorRepositoryInterface
{
    protected $model;

    public function __construct(Author $author){
        $this->model = $author;
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
        $author = $this->find($id);
        $author->update($attributes);
        return $author;
    }
    
    public function delete($id){
        return $this->model->destroy($id);
    }
    
}
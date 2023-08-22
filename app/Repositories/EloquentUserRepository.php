<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user){
        $this->model = $user;
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
        $user = $this->find($id);
        $user->update($attributes);
        return $user;
    }
    
    public function delete($id){
        return $this->model->destroy($id);
    }
    
}
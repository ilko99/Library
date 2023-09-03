<?php

namespace App\Models;

use App\Models\User;
use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function authors(){
        return $this->belongsToMany(Author::class)->withPivot(['author_id', 'book_id']);
    }

    public function user(){
        return $this->belongsToMany(User::class, 'user_book')->withPivot(['user_id', 'book_id']);
    }
}

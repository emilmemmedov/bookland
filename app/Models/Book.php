<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function authors(){
        return $this->belongsToMany(User::class,'user_books');
    }
}

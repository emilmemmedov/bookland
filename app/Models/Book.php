<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_books')->where('type', User::AUTHOR_TYPE);
    }

    public function publishers(){
        return $this->belongsToMany(User::class,'user_books')->where('type', User::PUBLISHER_TYPE);
    }
}

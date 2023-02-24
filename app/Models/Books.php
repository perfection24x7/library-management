<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['author_id', 'book_name', 'book_year'];

    public function author()
    {
        return $this->belongsTo(Authors::class, 'author_id', 'id');
    }

    public function book_library()
    {
        return $this->hasMany(BookLibrary::class, 'book_id', 'id');
    }
}

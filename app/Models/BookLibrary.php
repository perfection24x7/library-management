<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BookLibrary extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['book_id', 'library_id'];

    public function book()
    {
        return $this->belongsTo(Books::class, 'book_id', 'id');
    }

    public function library()
    {
        return $this->belongsTo(Libraries::class, 'library_id', 'id');
    }
}

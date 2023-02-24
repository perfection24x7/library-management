<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Libraries extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['library_name', 'library_address'];

    public function book_library()
    {
        return $this->hasMany(BookLibrary::class, 'library_id', 'id');
    }
}

<?php

namespace App\Repository;

use App\Models\Books;

class BooksRepository
{
    public function getBooks()
    {
        return Books::with(['author', 'book_library' => function ($q) {
            $q->latest();
        }, 'book_library.library'])->get();
    }

    public function create($data)
    {
        return Books::create($data);
    }

    public function update($data, $where)
    {
        return Books::where($where)->update($data);
    }

    public function delete($id)
    {
        return Books::find($id)->delete();
    }

    public function getBookData($id)
    {
        return Books::with([
            'author',
            'book_library' => function ($q) {
                $q->latest();
            },
            'book_library.library'
        ])->find($id);
    }
}

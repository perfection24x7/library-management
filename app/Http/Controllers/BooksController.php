<?php

namespace App\Http\Controllers;

use App\Repository\BooksRepository;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public $booksRepository;
    public function __construct(BooksRepository $booksRepository)
    {
        $this->booksRepository = $booksRepository;
    }

    public function index()
    {
        return view('books.index');
    }

    public function create()
    {
        return view('books.create');
    }

    public function edit($id)
    {
        $bookData = $this->booksRepository->getBookData($id);
        return view('books.edit')->with(compact('bookData'));
    }
}

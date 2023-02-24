<?php

namespace App\Repository;

use App\Models\Libraries;
use App\Models\BookLibrary;

class LibraryRepository
{
    public function create($data)
    {
        // If library_id exists then need to assign
        // or create new libraries
        if (count(array_filter($data['library_id'])) == 0) {
            for ($i = 0; $i < count($data['library_name']); $i++) {
                if (!empty($data['library_name'][$i]) && !empty($data['library_address'][$i])) {
                    $library_name = $data['library_name'][$i];
                    $library_address = $data['library_address'][$i];

                    $lib_data = compact('library_name', 'library_address');
                    $libraryObj = Libraries::create($lib_data);

                    $book_lib_data = [
                        'book_id' => $data['book_id'],
                        'library_id' => $libraryObj->id
                    ];
                    $this->saveBookLibraryData($libraryObj, $book_lib_data);
                }
            }
        } else {
            for ($i = 0; $i < count($data['library_id']); $i++) {
                $libraryObj = Libraries::find($data['library_id'][$i]);
                if($libraryObj) {
                    $book_lib_data = [
                        'book_id' => $data['book_id'],
                        'library_id' => $libraryObj->id
                    ];

                    $this->saveBookLibraryData($libraryObj, $book_lib_data);
                }
            }
        }
    }

    public function get()
    {
        return Libraries::get();
    }

    protected function saveBookLibraryData($libraryObj, $data)
    {
        $data['library_id'] = $libraryObj->id;
        $libraryObj->book_library()->create($data);
    }

    public function createOrUpdate($data, $id)
    {

        if (!empty($data['library_id'][0])) {
            BookLibrary::where('book_id', $id)->delete();
            for ($i = 0; $i < count($data['library_id']); $i++) {
                $libraryObj = Libraries::find($data['library_id'][$i]);
                $book_lib_data = ['book_id' => $id, 'library_id' => $libraryObj->id];
                $this->saveBookLibraryData($libraryObj, $book_lib_data);
            }
        } else {
            //delete all library which assign to this book
            BookLibrary::where('book_id', $id)->delete();
            for ($i = 0; $i < count($data['library_name']); $i++) {
                $library_name = $data['library_name'][$i];
                $library_address = $data['library_address'][$i];
                $lib_data = compact('library_name', 'library_address');
                $libraryObj = Libraries::create($lib_data);
                $book_lib_data = ['book_id' => $id, 'library_id' => $libraryObj->id];
                $this->saveBookLibraryData($libraryObj, $book_lib_data);
            }
        }
    }
}

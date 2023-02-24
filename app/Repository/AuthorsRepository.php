<?php

namespace App\Repository;

use App\Models\Authors;

class AuthorsRepository
{
    public function create($data)
    {
        return Authors::create($data);
    }

    public function get()
    {
        return Authors::get();
    }

    public function createOrUpdate($data, $id)
    {
        if (is_null($id)) {
            $data = Authors::updateOrCreate(['name' => $data['name']], $data);
            $author_id = $data->id;
        } else {
            return Authors::where(['id' => $id])->update($data);
            $author_id = $id;
        }

        return $author_id;
    }
}

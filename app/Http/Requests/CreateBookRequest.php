<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'book_name' => 'required',
            'book_year' => 'required',
            'author_id' => 'required_if:author_type,==,existing_author',
            'name' => 'required_if:author_type,==,new_author',
            'birth_date' => 'required_if:author_type,==,new_author',
            'genre' => 'required_if:author_type,==,new_author',
            'library_id' => 'nullable',
            'library_name' => 'nullable|array',
            'library_address' => 'nullable|array'
        ];
    }
}

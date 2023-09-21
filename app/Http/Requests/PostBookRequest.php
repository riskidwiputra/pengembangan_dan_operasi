<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        return [
            'isbn'              => 'required|numeric|unique:books,isbn',
            'title'             => 'required|String',
            'description'       => 'required|String',
            'authors'           => 'required|array',
            'authors.*'         => 'exists:authors,id',
            'published_year'    => 'required|Int|min:1900|Max:2020',
            'price'             => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }
}

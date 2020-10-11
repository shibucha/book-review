<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'keyword' => 'string|nullable',           
            'isbn' => 'integer|numeric|digits:13|nullable',
        ];
    }

    public function messages()
    {
        return [
            'isbn.integer' =>'ISBNコードは13桁の連続数値で検索してください。',
            'isbn.numeric' =>'ISBNコードは13桁の連続数値で検索してください。',
            'isbn.digits' =>'ISBNコードは13桁の連続数値で検索してください。',
        ];
    }
}

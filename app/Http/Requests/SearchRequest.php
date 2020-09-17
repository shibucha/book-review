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
            'isbn' => 'integer|numeric',
        ];
    }

    public function messages()
    {
        return [
            'isbn.integer' =>'ISBNコードは連続数値で検索してください。',
            'isbn.numeric' =>'ISBNコードは連続数値で検索してください。',
        ];
    }
}

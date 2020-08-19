<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadingRecordRequest extends FormRequest
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
            'reading_date' => 'date|before_or_equal:today|',
            'body' => 'max:500',
        ];
    }

    public function attributes()
    {
        return [
            'reading_date' => "読了日",
            'body' => "レビュー",
        ];
    }
}

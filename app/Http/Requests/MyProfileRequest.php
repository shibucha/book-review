<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyProfileRequest extends FormRequest
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
            'nickname' => 'string|nullable|max:20',     
            'self_introduction' => 'string|nullable|max:255', 
            'my_favorite_01' => 'string|nullable|max:50', 
            'my_favorite_02' => 'string|nullable|max:50', 
            'my_favorite_03' => 'string|nullable|max:50', 
            'my_favorite_reason_01' => 'string|nullable|max:255', 
            'my_favorite_reason_02' => 'string|nullable|max:255', 
            'my_favorite_reason_03' => 'string|nullable|max:255', 
            'my_favorite_isbn_01' => 'digits:13|nullable',
            'my_favorite_isbn_02' => 'digits:13|nullable',
            'my_favorite_isbn_03' => 'digits:13|nullable',
        ];
    }

    public function messages()
    {
        return [
            'nickname.max' => '20文字以内で入力してください.',
            'self_introduction.max' => '255文字以内で入力してください。',
            'my_favorite_01.max' => '50文字以内で入力してください',
            'my_favorite_02.max' => '50文字以内で入力してください',
            'my_favorite_02.max' => '50文字以内で入力してください',
            'my_favorite_reason_01.max' => '255文字以内で入力してください',
            'my_favorite_reason_02.max' => '255文字以内で入力してください',
            'my_favorite_reason_03.max' => '255文字以内で入力してください',
            'my_favorite_isbn_01.digits' => '連続する13桁の数字を入力してください。',
            'my_favorite_isbn_02.digits' => '連続する13桁の数字を入力してください。',
            'my_favorite_isbn_03.digits' => '連続する13桁の数字を入力してください。',
        ];
    }
}

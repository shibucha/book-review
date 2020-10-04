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
            'self-introduction' => 'string|nullable|max:255', 
            'my-favorite1' => 'string|nullable|max:50', 
            'my-favorite2' => 'string|nullable|max:50', 
            'my-favorite3' => 'string|nullable|max:50', 
            'my-favorite-reason1' => 'string|nullable|max:255', 
            'my-favorite-reason2' => 'string|nullable|max:255', 
            'my-favorite-reason3' => 'string|nullable|max:255', 
            'my-favorite-isbn1' => 'digits:13|nullable',
            'my-favorite-isbn2' => 'digits:13|nullable',
            'my-favorite-isbn3' => 'digits:13|nullable',
        ];
    }

    public function messages()
    {
        return [
            'nickname.max' => '20文字以内で入力してください.',
            'self-introduction.max' => '255文字以内で入力してください。',
            'my-favorite1.max' => '50文字以内で入力してください',
            'my-favorite2.max' => '50文字以内で入力してください',
            'my-favorite3.max' => '50文字以内で入力してください',
            'my-favorite-reason1.max' => '255文字以内で入力してください',
            'my-favorite-reason2.max' => '255文字以内で入力してください',
            'my-favorite-reason3.max' => '255文字以内で入力してください',
            'my-favorite-isbn1.digits' => '連続する13桁の数字を入力してください。',
            'my-favorite-isbn2.digits' => '連続する13桁の数字を入力してください。',
            'my-favorite-isbn3.digits' => '連続する13桁の数字を入力してください。',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => "required|max:10",
            'email' => "required|email",
            'message' => "required|max:1000",
        ];
    }

    public function messages(){

        return [     
            'message.max' => 'メッセージは１０００文字以内で記述してください。',
        ];
    }

    public function attributes(){

        return [
            'email' => 'メールアドレス',
            'message' => 'お問い合わせ内容'
        ];
    }
}

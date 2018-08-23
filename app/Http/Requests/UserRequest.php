<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

    public function messages()
    {
        return [
            'mobile.max'=> '手机号格式不正确'

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'=> 'required|min:6|max:20',
            'name'=> 'required|max:6',
            // 'mobile'=> 'required|max:3',
            'depa_id'=> 'required|numeric',
            // 'email'=>'email',
        ];
    }
}

<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UserAuthRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'email|required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email is required!',
            'password.required' => 'Password is required!',
        ];
    }
}

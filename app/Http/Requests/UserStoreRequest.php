<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'      => 'required|email|unique:users',
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'password'   => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'      => 'Email is required!',
            'first_name.required' => 'First name is required!',
            'last_name.required'  => 'Last name is required!',
            'password.required'   => 'Password is required!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'name'    => 'required|string|max:50',
            'email'   => 'email',
            'logo'    => 'mimes:png,jpg|max:2048',
            'website' => 'string',
        ];
    }

    public function messages(): array
    {
        return ['name.required' => 'Company name is required!'];
    }

    public function getValidatedData()
    {
        $validated = $this->validated();
        unset($validated['logo']);
        return json_encode($validated);
    }

    public function getLogo()
    {
        $validated = $this->validated();
        if (!empty($validated['logo'])) {
            return $validated['logo'];
        }
        return null;
    }
}

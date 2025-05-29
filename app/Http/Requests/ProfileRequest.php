<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => ['required', 'string', 'email'],
            'tanggal_lahir' => ['required', 'date', 'date_format:Y-m-d']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'no_hp' => 'No Hp',
            'email' => 'Email',
            'tanggal_lahir' => 'Date of Birth',
        ];
    }
}

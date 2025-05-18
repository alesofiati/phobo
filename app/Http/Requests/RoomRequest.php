<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nick_name' => [
                'required', 'exists:users,nick_name'
            ],
            'name' => [
                'required', 'string', 'max:255'
            ],
            'file' => [
                'sometimes', 'file', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'
            ],
        ];
    }
}

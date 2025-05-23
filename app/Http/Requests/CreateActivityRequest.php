<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateActivityRequest extends FormRequest
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
                'required', 'string', 'exists:users,nick_name'
            ],
            'room_code' => [
                'required', 'string', 'exists:rooms,code'
            ],
            'rating' => [
                'required', 'integer', 'between:1,5'
            ],
            'description' => [
                'sometimes', 'string'
            ],
            'image' => [
                'image'
            ],
            'episode' => [
                'required', 'integer'
            ],
            'season' => [
                'required', 'integer'
            ]
        ];
    }
}

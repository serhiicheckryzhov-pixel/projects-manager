<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends BaseProjectRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name' => 'required|string|max:255|min:3',
            'data.attributes.description' => 'nullable|string|max:255|min:3',
            'data.attributes.created_by' => 'required|exists:users,id',
            'data.attributes.related_to' => 'nullable|exists:users,id'
        ];
    }
}

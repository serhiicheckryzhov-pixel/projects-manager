<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;

class ReplaceProjectRequest extends BaseProjectRequest
{
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

<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProjectRequest extends BaseProjectRequest
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

        $rules = [
            'data.attributes.name' => 'required|string|max:255|min:3',
            'data.attributes.description' => 'sometimes|string|max:255|min:3',
            'data.attributes.created_by' => 'exists:users,id',
            'data.attributes.related_to' => 'sometimes|exists:users,id',
        ];

        if ($this->user()->tokenCan('project:own:update')) {
            $rules['data.attributes.created_by'] = 'prohibited';
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseProjectRequest extends FormRequest
{
    public function mappedAttributes(): array
    {
        $mappedAttributes = [
            'data.attributes.name' => 'name',
            'data.attributes.description' => 'description',
            'data.attributes.created_by' => 'created_by',
            'data.attributes.related_to' => 'related_to'
        ];
        $attributesToUpdate = [];

        foreach ($mappedAttributes as $key => $value) {
            if ($this->has($key)) {
                $attributesToUpdate[$value] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }
}

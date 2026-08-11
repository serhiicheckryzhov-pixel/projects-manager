<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    // public static $wrap = 'project';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'type' => 'project',
            'id' => $this->id,
            'includes' => new UserResource($this->whenLoaded('creator')),
            'attributes' => [
                'name' => $this->name,
                'description' => $this->when($request->routeIs('projects.show'), $this->description),
                // 'status' => $this->status
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                ],
            ],
            'links' => [
                'self' => route('projects.show', ['project' => $this->id]),
            ],
        ];
    }
}

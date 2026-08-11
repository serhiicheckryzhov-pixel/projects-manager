<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\ProjectFilter;
use App\Http\Requests\Api\V1\ReplaceProjectRequest;
use App\Http\Requests\Api\V1\StoreProjectRequest;
use App\Http\Requests\Api\V1\UpdateProjectRequest;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectFilter $filters): JsonResponse
    {
        $this->authorize('viewAny', Project::class);

        return ProjectResource::collection(Project::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        return (new ProjectResource(Project::create($request->mappedAttributes())))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $project_id): ProjectResource|JsonResponse
    {
        try {
            $project = Project::findOrFail($project_id);

            // Check if the user is authorized to view the current project
            $this->authorize('viewAuthor', $project);

            if ($this->include('creator')) {
                return new ProjectResource($project->load('creator'));
            }

            return new ProjectResource($project);

        } catch (ModelNotFoundException $e) {
            return $this->error('Project not found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to view this project', 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $project_id): JsonResponse
    {
        // PATCH

        try {
            $project = Project::findOrFail($project_id);
            $this->authorize('updateProject', $project);
            $project->update($request->mappedAttributes());

            return (new ProjectResource($project))
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return $this->error('Project not found', 404);
        }

    }

    public function replace(ReplaceProjectRequest $request, int $project_id): JsonResponse
    {
        // PUT
        try {
            $project = Project::findOrFail($project_id);

            $project->update($request->mappedAttributes());

            return (new ProjectResource($project))
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return $this->error('Project not found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $project_id): JsonResponse
    {
        try {
            $project = Project::findOrFail($project_id);
            $project->delete();
        } catch (ModelNotFoundException $e) {
            return $this->error('Project not found', 404);
        }

        return $this->ok('Project deleted successfully');
    }
}

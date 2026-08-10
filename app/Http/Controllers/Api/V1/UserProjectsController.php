<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\ProjectFilter;
use App\Http\Requests\Api\V1\ReplaceProjectRequest;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProjectsController extends ApiController
{
    public function index(int $user_id, ProjectFilter $filters)
    {
        return ProjectResource::collection(Project::where('created_by', $user_id)->filter($filters)->paginate());
    }

    public function destroy(int $user_id, int $project_id) : \Illuminate\Http\JsonResponse
    {
        try {
            $project = Project::findOrFail($project_id);

            if ($project->created_by == $user_id) {
                $project->delete();
            } else {
                return $this->error('Project not found for this particular user', 404);
            }


        } catch (ModelNotFoundException $e) {
            return $this->error('Project not found', 404);
        }

        return $this->ok('Project deleted successfully');
    }

    public function replace(ReplaceProjectRequest $request, $user_id, $project_id)
    {
        // PUT
        try {
            $project = Project::findOrFail($project_id);

            if ($project->created_by == $user_id) {
                $project->update($request->mappedAttributes());
            } else {
                return $this->error('Project not found for this particular user', 404);
            }


            return (new ProjectResource($project))
                ->response()
                ->setStatusCode(200);

        } catch(ModelNotFoundException $e) {
            return $this->error('Project not found', 404);
        }
    }
}


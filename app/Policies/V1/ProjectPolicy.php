<?php

namespace App\Policies\V1;


use App\Models\Project;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Support\Facades\Gate;

class ProjectPolicy
{
    public function viewAny(User $user) : bool
    {
        return true;
    }

    public function updateProject(User $user, Project $project) : bool
    {
        if ($user->tokenCan(Abilities::UpdateProject)) {
            return true;
        } elseif ($user->tokenCan(Abilities::UpdateOwnProject)) {
            return $user->id === $project->created_by;
        }

        return false;
    }

    public function viewAuthor(User $user, Project $project) : bool
    {
        return Gate::allows('admin-access', $project) || $user->id === $project->created_by;
    }
}

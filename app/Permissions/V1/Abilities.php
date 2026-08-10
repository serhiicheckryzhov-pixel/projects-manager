<?php

namespace App\Permissions\V1;

use App\Http\Requests\Api\V1\ReplaceProjectRequest;
use App\Models\User;

final class Abilities
{
    public const CreateProject  = 'project:create';
    public const UpdateProject  = 'project:update';
    public const ReplaceProject = 'project:replace';
    public const DeleteProject  = 'project:delete';

    public const UpdateOwnProject  = 'project:own:update';

    public const ReplaceOwnProject  = 'project:own:replace';
    public const DeleteOwnProject  = 'project:own:delete';

    public const CreateUser  = 'user:create';
    public const UpdateUser  = 'user:update';
    public const ReplaceUser = 'user:replace';
    public const DeleteUser  = 'user:delete';

    public static function getAbilities(User $user): ?array
    {
        if ($user->is_admin) {

            return [
                self::CreateProject,
                self::UpdateProject,
                self::ReplaceProject,
                self::DeleteProject,
                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,
            ];
        } else {
            return [
                self::UpdateOwnProject,
                self::DeleteOwnProject,
                self::ReplaceOwnProject,
            ];
        }

        return null;
    }
}

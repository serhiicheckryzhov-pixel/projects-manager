<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Permissions\V1\Abilities;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated();
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        $user = Auth::user();

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken('API token for '.$user->email, Abilities::getAbilities($user), now()->addMonth())->plainTextToken,
                Abilities::getAbilities($user),
                'user' => $user,

            ]
        );
    }

    public function register()
    {
        return $this->ok('Register');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Logout');
    }
}

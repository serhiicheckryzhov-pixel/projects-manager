<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    use ApiResponses, AuthorizesRequests;


    public function include(string $relationship): bool {
        $param = request()->get('include');

        if (!isset($param)){
           return false;
        }

        $includeValues = explode(',', mb_strtolower($param));

        return in_array(mb_strtolower($relationship), $includeValues);
    }
}

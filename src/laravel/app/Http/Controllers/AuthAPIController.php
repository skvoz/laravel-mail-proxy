<?php

namespace App\Http\Controllers;

use App\Entities\Users;
use App\Http\Requests\UserFormRequest;
use Illuminate\Routing\Controller;


class AuthAPIController extends Controller
{
    /**
     * @param UserFormRequest $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserFormRequest $response)
    {
        $users = new Users();
        $result = $users->stored($response);
        $status = isset($result['errors']) ? 404: 200;

        return response()->json($result, $status);
    }
}
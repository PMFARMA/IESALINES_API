<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    function authUser(Request $request)
    {
        return new UserResource($request->user());
    }

}

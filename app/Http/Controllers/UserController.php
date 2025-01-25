<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        $users=User::all();
        return response()->json([
           'success'=>true,
           'message'=>'Success',
           'users'=>$users
        ]);
    }
    public function me()
    {
        // use auth()->user() to get authenticated user data
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User fetched successfully!',
            ],
            'data' => [
                'user' => auth()->user(),
            ],
        ]);
    }
}

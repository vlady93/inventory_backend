<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login()
    {
        $credentials = request(['email', 'password']);

        try {
            if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
                //look for username
                $user = User::where([
                    ['username', $credentials['email']],
                    ['is_active', true]
                ])->first();
                if ($user) {
                    $credentials['email'] = $user->email;
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Invalid credentials. Please try again.'
                    ]);
                }
            } else {
                $user = User::where([
                    ['email', $credentials['email']]
                ])->first();
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'error' => ('Invalid credentials. Please try again.')
                    ]);
                }
            }

            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => ('Invalid credentials. Please try again.')
                ]);
            }
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => ('Could not create a token')]);
        }

        $response = [
            'success' => true,
            'token' => $token,
            'user_name' => $user->name,
        ];

        return response()->json($response);
    }

    public function logout()
    {
        // get token
        $token = JWTAuth::getToken();

        // invalidate token
        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Successfully logged out',
                ],
                'data' => [],
            ]);
        }
    }

    public function registerClient(Request $request)
    {
        $input = $request->only(['id', 'name', 'lastname', 'document_id']);

        if (isset($input['id'])) {
            try {
                $user = User::find($input['id']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return response()->json(['success' => false]);
            }
        } else {
            $user = new User();
        }

        $validator = Validator::make($input, [
            'name' => 'required',
            'lastname' => 'required',
            'document_id'=>'required|unique:users,document_id|max:12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user->name = $input['name'];
        $user->lastname = $input['lastname'];
        $user->document_id = $input['document_id'];
        $user->is_admin = false;
        $user->password = Hash::make('x');
        $user->save();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => ('User created successfully.')
            ]);
        }
    }
}

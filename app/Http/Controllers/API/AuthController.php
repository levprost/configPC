<?php

namespace App\Http\Controllers\Api; 
 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request; 
use App\Models\User; 
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; 
 
class AuthController extends Controller 
{ 
    public function __construct(User $user) 
    { 
        $this->user = $user; 
    } 
 
    public function register(Request $request) 
    { 
 
        $request->validate([ 
            'nick_name' => 'required|string|min:2|max:255', 
            'email_user' => 'required|email|unique:users', 
            'password' => 'required|string|min:6|max:255', 
        ]); 
 
 
        $user = $this->user::create([ 
            'nick_name' => $request['nick_name'], 
            'email_user' => $request['email_user'], 
            'password' => bcrypt($request['password']), 
        ]); 
 
        $token = auth()->login($user); 
 
        return response()->json([ 
            'meta' => [ 
                'code' => 200, 
                'status' => 'success', 
                'message' => 'User created successfully!', 
            ], 
            'data' => [ 
                'user' => $user, 
                'access_token' => [ 
                    'token' => $token, 
                    'type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 3600,  
                ], 
            ], 
        ]); 
    } 
 
    public function login(Request $request) 
    { 
        $request->validate([ 
            'email_user' => 'required|string', 
            'password_user' => 'required|string', 
        ]); 
 
        $token = auth()->attempt([ 
            'email_user' => $request->email, 
            'password' => $request->password, 
        ]); 
 
        if ($token) 
        { 
            return response()->json([ 
                'meta' => [ 
                    'code' => 200, 
                    'status' => 'success', 
                    'message' => 'Quote fetched successfully.', 
                ], 
                'data' => [ 
                    'user' => auth()->user(), 
                    'access_token' => [ 
                        'token' => $token, 
                        'type' => 'Bearer', 
                        'expires_in' => auth()->factory()->getTTL() * 3600, 
                    ], 
                ], 
            ]); 
        } 
    } 
 
    public function logout() 
    { 
       
        $token = JWTAuth::getToken(); 
 
        $invalidate = JWTAuth::invalidate($token); 
 
        if($invalidate) { 
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
} 


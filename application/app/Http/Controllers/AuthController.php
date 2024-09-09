<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Logs in a user.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        //validate the request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        //checks whether the user exists
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                'message' => 'user not found',
            ], 404);
        }

        //checks whether the password is correct using Hash
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'incorrect password',
            ], 400);
        }

        //stores the session for the logged in user
        Session::put('user_id', $user->user_id);
        Session::put('username', $user->username);

        return response()->redirectTo('/todos');
    }
    
    /**
     * Registers a new user.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        //validate the request
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
        ]);

        //checks whether the username already exists
        $existingUser = User::where('username', $request->username)->first();
        if ($existingUser) {
            return response()->json([
                'status' => 400,
                'message' => 'username already taken',
            ], 400);
        }

        //creates the user
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'user successfully created',
            'data' => $user,
        ], 201);
    }

    public function logout()
    {
        $user_id = Session::get('user_id');
        
        //checks whether the user exists
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'user not found',
            ], 404);
        }

        //clears the session
        Session::flush();

        return redirect('/login');
    }

    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function showRegistrationPage()
    {
        return view('auth.register');
    }
}
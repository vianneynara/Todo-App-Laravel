<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Creates a new user.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
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
                'message' => 'username already taken',
            ], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'user successfully created',
            'data' => $user,
        ], 201);
    }

    /**
     * Maybe unused, to update a user.
     * @param \Illuminate\Http\Request $request
     * @param int $user_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user_id) 
    {
        //validate the request
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
        ]);

        //checks whether the passed user exists
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'message' => 'user not found',
            ], 404);
        }

        //updates the user
        $user->update([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'user successfully updated',
            'data' => $user,
        ], 200);    
    }
}

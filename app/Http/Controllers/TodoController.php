<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Index todos of a user.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //validate the request
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        //selects the todos of the user
        $todos = Todo::where('user_id', $request->user_id)->get();

        return response()->json([
            'message' => 'todos successfully retrieved',
            'data' => $todos,
        ], 200);
    }

    /**
     * Creates a new todo.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        //validate the request
        $request->validate([
            'user_id' => 'required|integer',
            'description' => 'required|string',
        ]);

        //creates a new todo
        $todo = Todo::create([
            'user_id' => $request->user_id,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'todo successfully created',
            'data' => $todo,
        ], 201);
    }

    /**
     * Toggles the completion state of a todo.
     * @param \Illuminate\Http\Request $request
     * @param mixed $todo_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function toggleCompletion(Request $request, $todo_id)
    {
        //validate the request
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        //checks whether the passed todo exists and belongs to the user
        $todo = Todo::find($todo_id);
        if (!$todo || $todo->user_id !== $request->user_id) {
            return response()->json([
                //same message to protect confidentiality
                'message' => 'todo not found',
            ], 404);
        }

        //toggles the completion status of the todo
        $todo->update([
            'is_completed' => !$todo->is_completed,
        ]);

        return response()->json([
            'message' => 'todo successfully updated',
            'data' => $todo,
        ], 200);
    }

    /**
     * Deletes a todo.
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id) {
        //validate the request
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        //checks whether the passed todo exists and belongs to the user
        $todo = Todo::find($id);
        if (!$todo || $todo->user_id !== $request->user_id) {
            return response()->json([
                //same message to protect confidentiality
                'message' => 'todo not found',
            ], 404);
        }

        //deletes the todo
        $todo->delete();

        return response()->json([
            'message' => 'todo successfully deleted',
        ], 200);
    }
}

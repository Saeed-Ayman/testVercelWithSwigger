<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }

    public function show(Request $request, $id)
    {
        $user = User::all()->where('id', $id)->first();

        if ($user === null) {
            return response()->json(['message' => 'this user not found'], 404);
        }

        return response()->json([
            "status" => "success",
            "user" => $user
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = User::create($validator->getData());

        return response()->json([
            "status" => "success",
            "data" => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::all()->where('id', $id)->first();

        if ($user === null) {
            return response()->json(['message' => 'this user not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:8|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if (!password_verify($request->input('password'), $user->password)) {
            return response()->json(['message' => 'password is not correct'], 401);
        }

        $user->update($validator->getData());

        return response()->json([
            "status" => "success",
            "data" => $user
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::all()->where('id', $id)->first();

        if ($user === null) {
            return response()->json(['message' => 'this user not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if (!password_verify($request->input('password'), $user->password)) {
            return response()->json(['message' => 'password is not correct'], 401);
        }

        $user->delete();

        return response()->json([
            "status" => "success",
            "message" => "this user has been deleted"
        ]);
    }
}

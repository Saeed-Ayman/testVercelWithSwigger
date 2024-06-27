<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Info(title="User Controller", version="0.1")
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     tags={"test"},
     *     summary="get all users",
     *     operationId="index",
     *     @OA\Response(response="200", description="get all users.")
     * )
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }

    /**
     * @OA\Get(
     *     path="/api/test/{id}",
     *     tags={"test"},
     *     summary="show user",
     *     operationId="show",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *     ),
     *     @OA\Response(response="200", description="successful operation"),
     *     @OA\Response(response="401", description="unautharize"),
     *     @OA\Response(response="403", description="forbidden operation"),
     *     @OA\Response(response="404", description="user not found"),
     *     @OA\Response(response="422", description="unprocessable entity")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/test",
     *     tags={"test"},
     *     summary="create user",
     *     operationId="store",
     *     @OA\Parameter(
     *          name="name",
     *          in="query"
     *      ),
     *     @OA\Parameter(
     *           name="email",
     *           in="query"
     *       ),
     *     @OA\Parameter(
     *            name="password",
     *           in="query"
     *      ),
     *     @OA\Response(response="200", description="successful operation"),
     *     @OA\Response(response="403", description="forbidden operation"),
     *     @OA\Response(response="422", description="unprocessable entity")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/test/{id}",
     *     tags={"test"},
     *     summary="edit user data",
     *     operationId="update",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          in="query"
     *      ),
     *     @OA\Parameter(
     *           name="email",
     *           in="query"
     *       ),
     *     @OA\Parameter(
     *            name="password",
     *           in="query"
     *      ),
     *     @OA\Response(response="200", description="successful operation"),
     *     @OA\Response(response="401", description="unautharize"),
     *     @OA\Response(response="403", description="forbidden operation"),
     *     @OA\Response(response="404", description="user not found"),
     *     @OA\Response(response="422", description="unprocessable entity")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/test/{id}",
     *     tags={"test"},
     *     summary="remove user",
     *     operationId="destroy",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *     ),
     *      @OA\Parameter(
     *             name="password",
     *            in="query"
     *       ),
     *     @OA\Response(response="200", description="successful operation"),
     *     @OA\Response(response="401", description="unautharize"),
     *     @OA\Response(response="403", description="forbidden operation"),
     *     @OA\Response(response="404", description="user not found"),
     *     @OA\Response(response="422", description="unprocessable entity")
     * )
     */
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


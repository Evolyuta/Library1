<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="registerCreate",
     *     tags={"Authorization"},
     *     summary="Registation",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterStoreRequest")
     *     )
     * )
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'company' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
        ];
        $validatedData = $request->all();
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validatedData['password'] = bcrypt($request->password);
//        $validatedData['uuid'] = Str::uuid();
        $validatedData['uuid'] = $this->createUuid();

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['uuid' => $user['uuid'], 'password' => $request->password], 200);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="loginCreate",
     *     tags={"Authorization"},
     *     summary="Login",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginStoreRequest")
     *     )
     * )
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $rules = [
            'uuid' => 'required',
            'password' => 'required',
        ];
        $loginData = $request->all();
        $validator = Validator::make($loginData, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!auth()->attempt($loginData)) {
            if (!User::where('uuid', '=', $loginData['uuid'])->first()) {
                return response(['error' => 'Wrong uuid'], 401);
            };
            if (!User::where('password_decrypt', '=', $loginData['password'])->first()) {
                return response(['error' => 'Wrong password'], 401);
            };
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['access_token' => $accessToken], 200);
    }

    public function logout()
    {
        $userId = auth()->user()->id;
        DB::table('oauth_access_tokens')->where('user_id', '=', $userId)->delete();
    }

    public function get()
    {
        return response()->json(User::get(), 200);
    }

    private function createUuid()
    {
        if (!DB::table('users')->latest('created_at')->pluck('uuid')->first()) {
            return date("y") . date("m") . "-00001";
        } else {

            $monthOfLastUser = explode("-",
                DB::table('users')->latest('created_at')->pluck('created_at')->first())[1];
            $yearOfLastUser = substr(explode("-",
                DB::table('users')->latest('created_at')->pluck('created_at')->first())[0], 2, 2);

            if ($monthOfLastUser == date("m") && $yearOfLastUser == date("y")) {

                $indexOfLastUser = explode("-",
                    DB::table('users')->latest('created_at')->pluck('uuid')->first())[1];
                $index = $indexOfLastUser + "1";
                while (strlen($index) < 5) {
                    $index = "0" . $index;
                }

                return date("y") . date("m") . "-" . $index;
            } else {
                return date("y") . date("m") . "-00001";
            }

        }
    }
}

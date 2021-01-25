<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Log in as creating access token
     *
     * @return \Illuminate\Http\Response
     */
    protected function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => $validator->errors(),
            ]);
        }

        $user = User::where('email', $credentials['email'])
            ->where('password', $credentials['password'])
            ->first();
        if (is_null($user)) {
            return response()->json([
                'status' => 404,
                'message' => 'invalid credentials',
            ]);
        }

        $token = $user->createToken(SanctumPersonalAccessToken::SPA_TOKEN)->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'logged in successfully',
            'response' => [
                'token' => $token,
            ],
        ]);
    }

    /**
     * Log out as removing access token
     *
     * @return \Illuminate\Http\Response
     */
    protected function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'status' => 'success',
            'login' => false,
        ];
        return response()->json($response);
    }
}

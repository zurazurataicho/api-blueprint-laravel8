<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersonalAccessToken;
use App\Services\UserAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    protected function login(Request $request, UserAccountService $userAccountService)
    {
        $user = $userAccountService->find();
        if (is_null($user)) {
            return response([
                'status' => 401,
                'message' => 'required credentials'
            ], 401);
        }

        $token = $user->createToken(PersonalAccessToken::TOKEN_USER)->plainTextToken;
        $response = [
            'status' => 200,
            'message' => 'logged in successfully',
            'response' => [
                'token' => $token,
            ],
        ];
        return response()->json($response);
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
            'status' => 204,
            'message' => 'logged out successfully',
        ];
        return response()->json($response);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdminAccountService;
use App\Models\Admin;
use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
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
    protected function login(Request $request, AdminAccountService $adminAccountService)
    {
        $admin = $adminAccountService->find();
        if (is_null($admin)) {
            return response([
                'status' => 401,
                'message' => 'required credentials'
            ], 401);
        }

        $token = $admin->createToken(PersonalAccessToken::TOKEN_ADMIN)->plainTextToken;
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

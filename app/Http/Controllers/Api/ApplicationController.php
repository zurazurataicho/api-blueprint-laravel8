<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\PersonalAccessToken;
use App\Services\ApplicationAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
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
     * Issue an access token
     *
     * @return \Illuminate\Http\Response
     */
    protected function issue(Request $request, ApplicationAccountService $applicationAccountService)
    {
        $application = $applicationAccountService->find();
        if (is_null($application)) {
            return response([
                'status' => 401,
                'message' => 'required credentials'
            ], 401);
        }

        $token = $application->createToken(PersonalAccessToken::TOKEN_API)->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'response' => [
                'token' => $token,
            ],
        ]);
    }

    /**
     * Revoke an access token
     *
     * @return \Illuminate\Http\Response
     */
    protected function revoke(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'status' => 204,
            'message' => 'revoke successfully',
        ];
        return response()->json($response);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected function issue(Request $request)
    {
        $credentials = $request->only(['email', 'url']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'url' => 'required|url',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => $validator->errors(),
            ]);
        }

        $application = Application::where('email', $credentials['email'])
            ->where('url', $credentials['url'])
            ->first();
        if (is_null($application)) {
            return response()->json([
                'status' => 404,
                'message' => 'invalid credentials',
            ]);
        }

        $token = $application->createToken(self::API_TOKEN)->plainTextToken;
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
            'status' => 'success',
            'login' => false,
        ];
        return response()->json($response);
    }
}

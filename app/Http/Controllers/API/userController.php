<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginUser(Request $request)
    {
        $login=$request->all();
        Auth::attempt($login);
        $user=Auth::user();
        $token = $user->createToken('MyAppToken')->accessToken;
        return response(['status'=>200,'token'=>$token],200);
        // dd($token);
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     // Authentication was successful
        //     return response()->json(Auth::user(), 200);
        // } else {
        //     // Authentication failed
        //     return response()->json(['error' => 'Invalid credentials'], 401);
        // }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserDetail(Request $request)
    {
        // $user=Auth::guard('api')->user();
        // return response(['data'=>$user],200);
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            return Response(['data' => $user],200);
        }
        return Response(['data' => 'Unauthorized'],401);
    }

    public function userLogout()
    {
        if(Auth::guard('api')->check()){
            $accessToken = Auth::guard('api')->user()->token();

                \DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);
            $accessToken->revoke();

            return Response(['data' => 'Unauthorized','message' => 'User logout successfully.'],200);
        }
        return Response(['data' => 'Unauthorized'],401);
    }
    
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\User;

class ProfileController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['get']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $id = $request->id;
        $user = User::find($id);
        $streamer = $user->streamer()->first();
        if (!$user) {
            return response()->json([
                'errors' => ['user id not found'],
            ]);
        }
        return response()->json([
            'data' => [
                'avatar'    =>  $user->avatar,
                'username'  =>  $user->first_name,
                'nikname'   => $user->name,
                'bio'       => $user->bio,
                'email'     => '',
                'paypal'    => $streamer->paypal,
            ],
        ]);
    }

    public function getCurrent(Request $request) //// 
    {
        $user = auth()->user();
        
        return response()->json([
            'data' => [
                'id'        => $user->id,
                'avatar'    =>  $user->avatar,
                'username'  =>  $user->first_name,
                'nikname'   => $user->name,
                'bio'       => $user->bio,
                'email'     => $user->email,
                'paypal'    => '',
            ],
        ]);
    }
 
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\Viewer;
use App\Models\User;

class BotController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_type'      => 'required|min:1|max:256',
            'user_name'       => 'required|min:1|max:256',
            'channel_name'    => 'required|min:1|max:256',
            'timestamp'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $data = [
            'event_type'      => $request->event_type,
            'user_name'       => $request->user_name,
            'channel_name'    => $request->channel_name,
            'timestamp'       => $request->timestamp,
        ];
        return response()->json([
            'data' => $data,
        ]);
    }
 
}

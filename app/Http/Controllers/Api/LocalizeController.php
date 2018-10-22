<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
// use Carbon\Carbon;

// use App\Models\{User, Activity, Viewer, Streamer, ActiveStreamer};

class LocalizeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['translate']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function translate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'      => 'required|min:1|max:256',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        if ($request->has('locale')) {
            \App::setLocale($request->locale);
        }
        $data = \Lang::get($request->page);
        return response()->json([
            'data' => $data,
        ]);
    }
 
}

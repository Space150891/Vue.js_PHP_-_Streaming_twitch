<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Models\{User, Afiliate};

class AfiliateController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['visiter']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function visiter(Request $request, $id = 0)
    {
        $user = User::find($id);
        if ($user) {
            $ip = $request->ip();
            $old = Afiliate::where([
                ['user_id', '=', $user->id],
                ['ip_address', '=', $ip],
            ])->first();
            if (!$old) {
                $affiliate = new Afiliate();
                $affiliate->user_id = $user->id;
                $affiliate->ip_address = $ip;
                $affiliate->save();
            }
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mylist(Request $request)
    {
        $user = auth()->user();

        $visited = Afiliate::where('user_id', $user->id)->count();
        $registered = Afiliate::where('user_id', $user->id)->whereNotNull('register_at')->count();
        return response()->json([
            'data' => [
                'visited'       => $visited,
                'registered'    => $registered,
                'total'         => $visited + $registered,
            ],
        ]);
    }


}

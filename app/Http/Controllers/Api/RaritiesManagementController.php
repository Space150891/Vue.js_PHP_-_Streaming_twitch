<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use jeremykenedy\LaravelRoles\Models\Role;

use App\Models\Raritie;

class RaritiesManagementController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rarities = Raritie::all();
        return response()->json(['data' => [
            'rarities' => $rarities,
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'  => 'required|max:255|unique:rarities',
                'percent'  => 'required|numeric|max:100',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $raritie = new Raritie();
        $raritie->name = $request->name;
        $raritie->percent = $request->percent;
        $raritie->save();

        return response()->json([
            'message' => 'new raritie created successful',
            'data' => [
                'id' => $raritie->id,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $raritie = Raritie::find($id);

        if (!$raritie) {
            return response()->json([
                'errors' => ['raritie id not found'],
            ]);
        }

        return response()->json([
            'data' => $raritie,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
            'name'     => 'required|max:255',
            'percent'  => 'required|numeric|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $raritie = Raritie::find($request->id);

        if (!$raritie) {
            return response()->json([
                'errors' => ['raritie id not found'],
            ]);
        }

        $raritie->name = $request->name;
        $raritie->percent = $request->percent;
        $raritie->save();
        
        return response()->json([
            'message' => 'raritie update successful',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $raritie = Raritie::find($request->id);
        if (!$raritie) {
            return response()->json([
                'errors' => ['raritie id not found'],
            ]);
        }

        $raritie->delete();
        return response()->json([
            'message' => 'raritie delete successful',
        ]);
    }
}

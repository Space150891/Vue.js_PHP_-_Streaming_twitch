<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Diamond};

class DiamondsController extends Controller
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
        $diamonds = Diamond::all();
        return response()->json(['data' => [
            'diamonds' => $diamonds,
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
                'cost'          => 'required|numeric',
                'amount'        => 'required|numeric',
                'name'          =>  'required',
                'description'   =>  'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $set = new Diamond();
        $set->cost = $request->cost;
        $set->amount = $request->amount;
        $set->name = $request->name;
        $set->description = $request->description;
        $set->save();
        return response()->json([
            'message' => 'new diamonds set created successful',
            'data' => [
                'id' => $set->id,
            ]
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
        $validator = Validator::make($request->all(),
            [
                'id'            => 'required|numeric|min:1',
                'cost'          => 'required|numeric',
                'amount'        => 'required|numeric',
                'name'          => 'required',
                'description'   => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $set = Diamond::find($request->id);
        if (!$set) {
            return response()->json([
                'errors' => ['diamonds set id not found'],
            ]);
        }
        $set->cost = $request->cost;
        $set->amount = $request->amount;
        $set->name = $request->name;
        $set->description = $request->description;
        $set->save();
        return response()->json([
            'message' => 'diamonds set updated successful',
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
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $set = Diamond::find($request->id);
        if (!$set) {
            return response()->json([
                'errors' => ['diamonds set id not found'],
            ]);
        }
        $set->delete();
        return response()->json([
            'message' => 'diamond set delete successful',
        ]);
    }

}

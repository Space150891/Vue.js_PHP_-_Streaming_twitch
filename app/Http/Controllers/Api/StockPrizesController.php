<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\{StockPrize};

class StockPrizesController extends Controller
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
        $prizes = StockPrize::all();
        return response()->json(['data' => [
            'prizes' => $prizes,
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
                'name'          => 'required|max:255|min:1',
                'description'   => 'string|max:1023',
                'cost'          => 'numeric',
                'amount'        => 'numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $prize = new StockPrize();
        $prize->name = $request->name;
        $prize->description = $request->has('description') ? $request->description : '';
        $prize->cost = $request->has('cost') ? $request->cost : 0;
        $prize->amount = $request->has('amount') ? $request->amount : 0;
        $prize->save();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            // $fileName = 'prize_' . $prize->id . '_' . $extention;
            $fileName = $this->generateFileName($extention);
            $destination = 'public/stock';
            Storage::putFileAs($destination, $file, $fileName);
            $prize->image = 'stock/' . $fileName;
            $prize->save();
        }
        return response()->json([
            'message' => 'new stock prize created successful',
            'data' => [
                'id' => $prize->id,
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
                'name'          => 'required|max:255|min:1',
                'description'   => 'string|max:1023',
                'cost'          => 'numeric',
                'amount'        => 'numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $prize = StockPrize::find($request->id);
        if (!$prize) {
            return response()->json([
                'errors' => ['stock prize id not found'],
            ]);
        }
        $prize->name = $request->name;
        $prize->description = $request->has('description') ? $request->description : $prize->description;
        $prize->cost = $request->has('cost') ? $request->cost : $prize->cost;
        $prize->amount = $request->has('amount') ? $request->amount : $prize->amount;
        $prize->save();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            // $fileName = 'prize_' . $prize->id . '_' . $extention;
            $fileName = $this->generateFileName($extention);
            $destination = 'public/stock';
            Storage::putFileAs($destination, $file, $fileName);
            $prize->image = 'stock/' . $fileName;
            $prize->save();
        }
        return response()->json([
            'message' => 'stock prize update successful',
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
                'errors' => $validator->errors(),
            ]);
        }
        $prize = StockPrize::find($request->id);

        if (!$prize) {
            return response()->json([
                'errors' => ['stock prize id not found'],
            ]);
        }
        if ($prize->image) {
            Storage::delete('public/' . $prize->image);
        }
        $prize->delete();

        return response()->json([
            'message' => 'stock prize delete successful',
        ]);
    }


    private function generateFileName($ext) {
        do {
            $name = 'prize_' . uniqid() . '_' . $ext;
        } while(Storage::exists('public/stock/' . $name));
        return $name;
    }

}

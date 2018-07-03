<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\CaseType;

class CaseTypesManagementController extends Controller
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
        $caseTypes = CaseType::all();
        return response()->json(['data' => [
            'caseTypes' => $caseTypes,
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
                'name'  => 'required|max:255|unique:case_types',
                'price'  => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $caseType = new CaseType();
        $caseType->name = $request->name;
        $caseType->price = $request->price;
        $caseType->save();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $caseType->id . '_' . $extention;
            $destination = 'public/case_types/';
            Storage::putFileAs($destination, $file, $fileName);
            $caseType->image = 'case_types/' . $fileName;
            $caseType->save();
        }

        return response()->json([
            'message' => 'new case type created successful',
            'data' => [
                'id' => $caseType->id,
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
        $caseType = CaseType::find($id);

        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }

        return response()->json([
            'data' => $caseType,
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
            'price'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $caseType = CaseType::find($request->id);

        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }

        $caseType->name = $request->name;
        $caseType->price = $request->price;
        $caseType->save();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $caseType->id . '_' . $extention;
            $destination = 'public/case_types/';
            Storage::putFileAs($destination, $file, $fileName);
            $caseType->image = 'case_types/' . $fileName;
            $caseType->save();
        }
        
        return response()->json([
            'message' => 'case type update successful',
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
        $caseType = CaseType::find($request->id);
        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }

        $caseType->delete();
        return response()->json([
            'message' => 'case type delete successful',
        ]);
    }
}

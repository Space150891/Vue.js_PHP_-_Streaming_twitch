<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\ContactType;

class ContactTypesManagementController extends Controller
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
        $contactTypes = ContactType::all();
        return response()->json(['data' => [
            'contact types' => $contactTypes,
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
                'name'  => 'required|max:255|unique:contact_types',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        $contactType = new ContactType();
        $contactType->name = $request->name;
        $contactType->save();
        
        return response()->json([
            'message' => 'new contsact type created successful',
            'data' => [
                'id' => $contactType->id,
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
        $contactType = ContactType::find($id);

        if (!$contactType) {
            return response()->json([
                'errors' => ['contact type id not found'],
            ]);
        }

        return response()->json([
            'data' => $contactType,
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        $contactType = ContactType::find($request->id);

        if (!$contactType) {
            return response()->json([
                'errors' => ['contact type id not found'],
            ]);
        }

        $contactType->name = $request->name;
        $contactType->save();
        
        return response()->json([
            'message' => 'contact type update successful',
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
        $contactType = ContactType::find($request->id);

        if (!$contactType) {
            return response()->json([
                'errors' => ['contact type id not found'],
            ]);
        }

        $contactType->delete();
        return response()->json([
            'message' => 'contact type delete successful',
        ]);
    }
}

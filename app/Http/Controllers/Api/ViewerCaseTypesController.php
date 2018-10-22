<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Viewer, CaseType, BuyedCaseType};

class ViewerCaseTypesController extends Controller
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
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewerCaseTypes = $viewer->buyedCaseTypes()->get();
        $cases = [];
        foreach ($viewerCaseTypes as $vieverCase) {
            $cases[] = [
                'case'      => $vieverCase->case()->first(),
                'total'     => $vieverCase->total,
        ];
        }
        return response()->json(['data' => [
            'cases' => $cases,
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
                'id'   =>  'required|numeric|min:1',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        if (!CaseType::find($request->id)) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $case = BuyedCaseType::where([
            ['viewer_id', '=', $viewer->id],
            ['case_type_id', '=', $request->id],
        ])->first();
        if (!$case) {
            $case = new BuyedCaseType();
        }
        $case->viewer_id = $viewer->id;
        $case->case_type_id = $request->id;
        $case->total = $case->total + 1;
        $case->save();
        
        return response()->json([
            'message' => 'case type added to viewer',
        ]);
    }

}

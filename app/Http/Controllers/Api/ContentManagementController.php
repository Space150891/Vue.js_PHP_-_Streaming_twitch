<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{MainContent};

class ContentManagementController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function show(Request $request)
    {
        $data = [];
        $content = MainContent::all();
        foreach ($content as $cont) {
            $data[$cont->name] = $cont->content;
        }
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $content = json_decode($request->content);
        //dd($content);
        foreach ($content as $cont) {
            $existContent = MainContent::where('name', $cont->name)->first();
            if ($existContent) {
                $existContent->content = $cont->content;
                $existContent->save();
            } else {
                $newContent = new MainContent();
                $newContent->name = $cont->name;
                $newContent->content = $cont->content;
                $newContent->save();
            }
        }
        return response()->json([
            'message' => 'content saved',
        ]);
    }
 
}

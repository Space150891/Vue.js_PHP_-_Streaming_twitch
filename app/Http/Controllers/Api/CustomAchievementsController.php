<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;
use App\Models\{Viewer, Streamer, User, CustomAchievement};


class CustomAchievementsController extends Controller
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

    public function index(Request $request)
    {
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $all = CustomAchievement::where('streamer_id', $streamer->id)->get();
        return response()->json([
            'data' => [
                'achievements' => $all,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $total = CustomAchievement::where('streamer_id', $streamer->id)->count();
        if ($total > 9) {
            return response()->json([
                'errors' => ['maximum custom achivements reached'],
            ]);
        }
        $new = new CustomAchievement();
        $new->streamer_id = $streamer->id;
        $new->text = $request->text;
        $new->status = "draft";
        $new->save();
        return response()->json([
            'message' => 'custom achivement created',
        ]);
    }

    public function deleteMy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $custom = CustomAchievement::where([
            ['streamer_id', '=', $streamer->id],
            ['id', '=', $request->id],
        ])->first();
        if (!$custom) {
            return response()->json([
                'errors' => ['can not find achivement id'],
            ]);
        }
        $oldMain = $custom->main;
        $custom->delete();
        if ($oldMain == 1) {
            $first = CustomAchievement::where([
                ['streamer_id', '=', $streamer->id],
                ['status', '=', 'ok']
            ])->orderBy('updated_at', 'desc')->first();
            if ($first) {
                $first->main = 1;
                $first->save();
            }
        }
        return response()->json([
            'message' => 'custom achivement deleted',
        ]);
    }

    public function main(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $main = CustomAchievement::where([
            ['streamer_id', '=', $streamer->id],
            ['id', '=', $request->id],
        ])->first();
        if (!$main) {
            return response()->json([
                'errors' => ['can not find achivement id'],
            ]);
        }
        $allCustom = CustomAchievement::where('streamer_id', $streamer->id)->get();
        foreach ($allCustom as $custom) {
            $custom->main = 0;
            $custom->save();
        }
        $main->main = 1;
        $main->save();
        return response()->json([
            'message' => 'custom achievement set as main',
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $custom = CustomAchievement::where([
            ['id', '=', $request->id],
        ])->first();
        if (!$custom) {
            return response()->json([
                'errors' => ['can not find achivement id'],
            ]);
        }
        $oldMain = $custom->main;
        $custom->delete();
        if ($oldMain == 1) {
            $first = CustomAchievement::where([
                ['streamer_id', '=', $streamer->id],
                ['status', '=', 'ok']
            ])->orderBy('updated_at', 'desc')->first();
            if ($first) {
                $first->main = 1;
                $first->save();
            }
        }
        return response()->json([
            'message' => 'custom achivement deleted',
        ]);
    }

    public function ok(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $custom = CustomAchievement::where([
            ['id', '=', $request->id],
        ])->first();
        if (!$custom) {
            return response()->json([
                'errors' => ['can not find achivement id'],
            ]);
        }
        $custom->status = "ok";
        $main = CustomAchievement::where([
            ['streamer_id', '=', $custom->streamer_id],
            ['main', '=', 1],
        ])->first();
        if (!$main) {
            $custom->main = 1;
        }
        $custom->save();
        return response()->json([
            'message' => 'custom achivement OK',
        ]);
    }

    public function block(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $custom = CustomAchievement::where([
            ['id', '=', $request->id],
        ])->first();
        if (!$custom) {
            return response()->json([
                'errors' => ['can not find achivement id'],
            ]);
        }
        $custom->status = "block";
        $custom->save();
        return response()->json([
            'message' => 'custom achivement BLOCKED',
        ]);
    }

    public function all(Request $request)
    {
        $all = CustomAchievement::all();
        return response()->json([
            'data' => [
                'achievements' => $all,
            ],
        ]);
    }
 
}

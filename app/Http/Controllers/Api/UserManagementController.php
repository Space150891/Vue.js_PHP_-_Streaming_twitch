<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\CaptureIpTrait;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Storage;
use jeremykenedy\LaravelRoles\Models\Role;

use App\Models\{Profile, User, Viewer, Streamer, SignedViewer, SubscribedStreamers, SubscriptionPlan, MonthPlan};

class UserManagementController extends Controller
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
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'       => 'required|numeric|min:1',
            'on_page'       => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $adminRoleId = \DB::table('roles')->where('name', 'admin')->first()->id;
        $adminId = \DB::table('role_user')->where('role_id', $adminRoleId)->value('user_id');
        $total = User::where('id', '!=', $adminId)->count();
        $pages = ceil($total / $request->on_page);
        $users = User::select(
                            'users.id',
                            'users.name',
                            'users.email',
                            'users.twitch_id',
                            'users.created_at',
                            'viewers.level_points',
                            'viewers.diamonds',
                            'streamers.id as streamer_id'
                            )
                            ->leftJoin('streamers', 'streamers.user_id', '=', 'users.id')
                            ->leftJoin('viewers', 'viewers.user_id', '=', 'users.id')
                            ->where('users.id', '!=', $adminId)
                            ->orderBy('users.created_at', 'asc')
                            ->skip(($request->page - 1) * $request->on_page)
                            ->take($request->on_page)->get();
        for ($i = 0; $i < count($users); $i++) {
            $viewer = $users[$i]->viewer()->first();
            $users[$i]->level = $viewer ? $viewer->getLevel() : 0;
            $users[$i]->followers = SignedViewer::where('streamer_id', $users[$i]->streamer_id)->count();
        }
        return response()->json([
            'data' => [
                'users'     => $users,
                'pages'     => $pages,
            ],
        ]);
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
                'name'                  => 'required|max:255|unique:users',
                'first_name'            => '',
                'last_name'             => '',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'name.unique'         => trans('auth.userNameTaken'),
                'name.required'       => trans('auth.userNameRequired'),
                'first_name.required' => trans('auth.fNameRequired'),
                'last_name.required'  => trans('auth.lNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'password.required'   => trans('auth.passwordRequired'),
                'password.min'        => trans('auth.PasswordMin'),
                'password.max'        => trans('auth.PasswordMax'),
                'role.required'       => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        $ipAddress = new CaptureIpTrait();
        $profile = new Profile();

        $user = User::create([
            'name'             => $request->input('name'),
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'email'            => $request->input('email'),
            'password'         => bcrypt($request->input('password')),
            'token'            => str_random(64),
            'admin_ip_address' => $ipAddress->getClientIp(),
            'activated'        => 1,
        ]);

        $user->profile()->save($profile);
        $user->attachRole($request->input('role'));
        $user->save();
        
        $viewer = new Viewer();
        $viewer->name = $user->name;
        $viewer->user_id = $user_id;
        $viewer->save();
        $streamer = new Streamer();
        $streamer->name = $user->name;
        $streamer->user_id = $user_id;
        $streamer->save();

        return response()->json([
            'message' => 'new user created successful',
            'data' => [
                'id' => $user->id,
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
        $id = $request->id;
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'errors' => ['user id not found'],
            ]);
        }
        $streamer = $user->streamer()->first();
        $viewer = $user->viewer()->first();
        $data = [
            'id'            => $user->id,
            'name'          => $user->name,
            'subscriptions' => $streamer ? $this->getSubscriptiosList($streamer->id) : [],
        ];
        return response()->json([
            'data' => $data,
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
        $id = $request->id;
        $currentUser = Auth::user();
        $user = User::find($id);
        $emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $ipAddress = new CaptureIpTrait();

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|max:255|unique:users',
                'email'    => 'email|max:255|unique:users',
                'password' => 'present|confirmed|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|max:255|unique:users',
                'password' => 'nullable|confirmed|min:6',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        $user->name = $request->input('name');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        if ($emailCheck) {
            $user->email = $request->input('email');
        }

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $userRole = $request->input('role');
        if ($userRole != null) {
            $user->detachAllRoles();
            $user->attachRole($userRole);
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        switch ($userRole) {
            case 3:
                $user->activated = 0;
                break;

            default:
                $user->activated = 1;
                break;
        }

        $user->save();
        return response()->json([
            'message' => 'user update successful',
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
        $id = $request->id;
        $currentUser = Auth::user();
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'errors' => ['user id not found'],
            ]);
        }

        $ipAddress = new CaptureIpTrait();

        if ($user->id != $currentUser->id) {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            return response()->json([
                'message' => 'user deleted successful',
            ]);
        }

        return response()->json([
            'errors' => ['can not delete yourself'],
        ]);
    }

    /**
     * Method to search the users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('user_search_box');
        $searchRules = [
            'user_search_box' => 'required|string|max:255',
        ];
        $searchMessages = [
            'user_search_box.required' => 'Search term is required',
            'user_search_box.string'   => 'Search term has invalid characters',
            'user_search_box.max'      => 'Search term has too many characters - 255 allowed',
        ];

        $validator = Validator::make($request->all(), $searchRules, $searchMessages);

        if ($validator->fails()) {
            return response()->json([
                json_encode($validator),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $results = User::where('id', 'like', $searchTerm.'%')
                            ->orWhere('name', 'like', $searchTerm.'%')
                            ->orWhere('email', 'like', $searchTerm.'%')->get();

        // Attach roles to results
        foreach ($results as $result) {
            $roles = [
                'roles' => $result->roles,
            ];
            $result->push($roles);
        }

        return response()->json([
            json_encode($results),
        ], Response::HTTP_OK);
    }

    private function getSubscriptiosList($streamerId)
    {
        $list = [];
        $subscriptions = SubscribedStreamers::where('streamer_id', $streamerId)->get();
        foreach ($subscriptions as $subscription) {
            $monthPlan = MonthPlan::find($subscription->month_plan_id);
            $subPlan = SubscriptionPlan::find($subscription->subscription_plan_id);
            $plan = new \stdClass();
            $plan->subscription = $subPlan->name;
            $plan->month = $monthPlan->monthes;
            $plan->valid_from = $subscription->valid_from;
            $plan->valid_until = $subscription->valid_until;
            $list[] = $plan;
        }
        return $list;
    }

}

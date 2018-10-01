<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{
    Achievement,
    Activity,
    Item,
    Game,
    Notification,
    Profile,
    RarityClass,
    Streamer,
    SubscribedStreamers,
    User,
    Viewer,
    ViewerItem
};
use GuzzleHttp\Client as Guzzle;
use LiqPay;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'try';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
    }

    private function se()
    {
        $client = new Guzzle();
        $streamer = Streamer::find(103);
        $response = $client->get('https://api.streamelements.com/kappa/v2/channels/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . $streamer->streamelements_access,
            ]
        ]);
        $result = json_decode((string)$response->getBody(), true);
        $channelId = $result['_id'];
        // dd($channelId);
        ///
        $response = $client->get('https://api.streamelements.com/kappa/v2/tips/' . $channelId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $streamer->streamelements_access,
            ],
        ]);
        $result = json_decode((string)$response->getBody(), true);
        var_dump($result);
        ///
        try {
            $response = $client->post('https://api.streamelements.com/kappa/v2/tips/' . $channelId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $streamer->streamelements_access,
                ],
                'form_params' => [
                    'currency'      => 'USD',
                    "payFees"       => false,
                    "user" => [
                        "username"  => "viewer",
                        "email"     => "viewer@mail.com"
                    ],
                    "amount"        => 100.00,
                    "message"       => "Donation",
                    "imported"      => 'true',
                ],
            ]);
        } catch(\Exception $e) {
            exit($e->getMessage());
        }

        $result = json_decode((string)$response->getBody(), true);
        var_dump($result);
        // $result = (string)$response->getBody();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channels'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $streamers = [];
        foreach ($request->channels as $channel) {
            $streamers[] = Streamer::where('name', $channel)->first();
            if (!$streamer) {
                return response()->json([
                    'errors' => 'streamer not found',
                ]);
            }
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $now = new Carbon();
        $updatedTime = $now->toDateTimeString();
        $points = 0;
        foreach ($streamers as $streamer) {
            $active = $this->checkViewerOnline($viewer->id, $streamer->id);
            if ($active) {
                $points += $this->calculatePoints($viewer->id, $streamer->id);
                $active->updated_at = $updatedTime;
                $active->save();
            } else {
                $this->newActivity($viewer->id, $streamer->id);
            }
        }
        $this->giveAfiliates();
        $data = [
            'points' => $points
        ];
    }

    private function calculatePoints($viewerId, $streamerId)
    {
        $points = 0;
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.valid_pause'));
        $updateTime = $now->toDateTimeString();
        $tolalViewers = Activity::where([
            ['streamer_id', '=', $streamerId],
            ['updated_at', '>', $updateTime]
        ])->count();
        $subscribed = SubscribedStreamers::where([
            ['streamer_id', '=', $streamerId],
            ['valid_from', '<=', $updateTime],
            ['valid_until', '>=', $updateTime],
        ])->first();
        if ($subscribed) {
            $plan = SubscriptionPlan::find($subscribed->subscription_plan_id);
            $points += $plan->points;
            $bonusPoints = SubscriptionPoint::where('subscription_plan_id', $subscribed->subscription_plan_id)->get();
            foreach ($bonusPoints as $bonusPoint) {
                if ($bonusPoint->from_viewers >= $tolalViewers && $bonusPoint->to_viewers <= $tolalViewers) {
                    $points += $bonusPoint->points;
                }
            }
        }
        return $points;
    }

    private function giveAfiliates()
    {
        $user = auth()->user();
        $afiliate = Afiliate::where('afiliate_id', $user->id)->whereNotNull('confirm_at')->first();
        if ($afiliate) {
            $userReferal = User::find($afiliate->user_id);
            $viewerReferal = $userReferal->viewer()->first();
            $viewerReferal->current_points = $viewerReferal->current_points + 1;
            $viewerReferal->level_points = $viewerReferal->level_points + 1;
            $viewerReferal->save();
        }
    }

    private function checkViewerOnline($viewerId, $streamerId)
    {
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.valid_pause'));
        $updateTime = $now->toDateTimeString();
        return Activity::where([
            ['viewer_id', '=', $viewerId],
            ['streamer_id', '=', $streamerId],
            ['updated_at', '>', $updateTime]
        ])->first();
    }

    private function newActivity($viewerId, $streamerId)
    {
        $activity = Activity::where([
            ['viewer_id', '=', $viewerId],
            ['streamer_id', '=', $streamerId],
        ])->first();
        if ($activity) {
            $now = new Carbon;
            $activity->updated_at = $now->toDateTimeString();
        } else {
            $activity = new Activity();
            $activity->viewer_id = $viewerId;
            $activity->streamer_id = $streamerId;
        }
        $activity->save();
    }
    
}

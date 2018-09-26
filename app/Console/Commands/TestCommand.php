<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game, ViewerItem, Activity, Item, Notification, SubscribedStreamers, RarityClass, Achievement};
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
        $this->ach();
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
    
    private function sl()
    {
        $streamer = Streamer::find(103);
        $client = new Guzzle();
        $response = $client->post('https://streamlabs.com/api/v1.0/donations', [
            'headers' => [
                'Authorization' => 'Bearer ' . $streamer->streamlabs_access,
            ],
            'form_params' => [
                "name"          => "Fishstickslol",
                "message"       => "new donation!!!",
                "identifier"    => "streamer@mail.ru",
                "amount"        => 10,
                "currency"      => "USD",
            ]
        ]);
        $result = json_decode((string)$response->getBody(), true);
        var_dump($result);
    }

    private function ach()
    {
        $rarityClasses = RarityClass::all();
        $classes = [];
        foreach ($rarityClasses as $rarityClass) {
            $classes[$rarityClass->name] = $rarityClass->id;
        }
        var_dump($classes);
        $data = [
            [
                'class_name'    =>  'App\Achievements\AccountVerifiedAchievement',
                'name'          =>  'The Trusty',
                'description'   =>  'Verify your Phone #',
                'steps'         =>  1,
                'level_points'  =>  2000,
            ],
            [
                'class_name'    =>  'App\Achievements\Buy100DiamondsAchievement',
                'name'          =>  'buy 100 diamonds',
                'description'   =>  'Buyed 100 diamonds',
                'steps'         =>  100,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\BuyFirstCaseAchievement',
                'name'          =>  'buy first case',
                'description'   =>  'Buyed first case',
                'steps'         =>  1,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\BuyFirstDiamondsAchievement',
                'name'          =>  'first diamond',
                'description'   =>  'Buy first diamonds',
                'steps'         =>  1,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Donate100Achievement',
                'name'          =>  'I like donating even more',
                'description'   =>  'Your Total Donations (Globally) equals at least 100 USD',
                'steps'         =>  100,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'frame_rarity_id' => $classes['epic'],
                'case_rarity_id' => $classes['epic'],
            ],
            [
                'class_name'    =>  'App\Achievements\FB10likeAchievement',
                'name'          =>  'FB 10 likes',
                'description'   =>  'You make 10 facebook likes',
                'steps'         =>  10,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FB20likeAchievement',
                'name'          =>  'FB 20 likes',
                'description'   =>  'You make 20 facebook likes',
                'steps'         =>  20,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FB50likeAchievement',
                'name'          =>  'FB 50 likes',
                'description'   =>  'You make 50 facebook likes',
                'steps'         =>  50,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FirstDonateAchievement',
                'name'          =>  'The generous',
                'description'   =>  'Donate to a Channel for the first time',
                'steps'         =>  1,
                'level_points'  =>  1000,
                'diamonds'      =>  1,
                'card_rarity_id' => $classes['random'],
                'case_rarity_id' => $classes['uncommon'],
            ],
            [
                'class_name'    =>  'App\Achievements\FirstFBlikeAchievement',
                'name'          =>  'I like StreamCases.tv',
                'description'   =>  'First like on Facebook',
                'steps'         =>  1,
                'level_points'  =>  500,
                'diamonds'      =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FirstLoginAchievement',
                'name'          =>  'Welcome',
                'description'   =>  'Login the first time.',
                'steps'         =>  1,
                'level_points'  =>  1,
                'hero_rarity_id' => $classes['default'],
                'frame_rarity_id' => $classes['default'],
            ],
            [
                'class_name'    =>  'App\Achievements\FirstNonPriceWinAchievement',
                'name'          =>  'first item win',
                'description'   =>  'Your first item win',
                'steps'         =>  1,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FirstPriceWinAchievement',
                'name'          =>  'I am legend',
                'description'   =>  'Win a real price the first time',
                'steps'         =>  1,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FirstReferViewerAchievement',
                'name'          =>  'first refer viewer',
                'description'   =>  'First refer viewer',
                'steps'         =>  1,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\FirstStreamerSubscribeAchievement',
                'name'          =>  'The faithful',
                'description'   =>  'Subscribe to a Channel for the first time / 1 Channel',
                'steps'         =>  1,
                'level_points'  =>  5000,
                'card_rarity_id' => $classes['plain'],
                'case_rarity_id' => $classes['uncommon'],
            ],
            [
                'class_name'    =>  'App\Achievements\FirstTweetAchievement',
                'name'          =>  'Tweet Tweet!',
                'description'   =>  'First Tweet on Twitter',
                'steps'         =>  1,
                'level_points'  =>  500,
                'diamonds'      =>  10,
                'card_rarity_id' => $classes['twitter'],
            ],
            [
                'class_name'    =>  'App\Achievements\FirstWinAchievement',
                'name'          =>  'I am lucky',
                'description'   =>  'Win anything out of a StreamCase for the first time',
                'steps'         =>  1,
                'level_points'  =>  1000,
            ],
            [
                'class_name'    =>  'App\Achievements\Login10daysAchievement',
                'name'          =>  'login 10 days',
                'description'   =>  'Login 10 days',
                'steps'         =>  10,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Login20daysAchievement',
                'name'          =>  'login 20 days',
                'description'   =>  'Login 20 days',
                'steps'         =>  20,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\NNonPricesWinAchievement',
                'name'          =>  '100 items win',
                'description'   =>  'Win 100 items',
                'steps'         =>  100,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\NPricesWinAchievement',
                'name'          =>  '100 prices win',
                'description'   =>  'Win 100 prises',
                'steps'         =>  100,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Open2CasesAchievement',
                'name'          =>  'open 2 cases',
                'description'   =>  'Opened 2 cases',
                'steps'         =>  2,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Open3CasesAchievement',
                'name'          =>  'open 3 cases',
                'description'   =>  'Open 3 cases',
                'steps'         =>  3,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Open5CasesAchievement',
                'name'          =>  'open 5 cases',
                'description'   =>  'Open 5 cases',
                'steps'         =>  5,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\OpenFirstCaseAchievement',
                'name'          =>  'Lets give it a try',
                'description'   =>  'Open any StreamCase for the first time',
                'steps'         =>  1,
                'level_points'  =>  0,
                'diamonds'      =>  1,
            ],
            [
                'class_name'    =>  'App\Achievements\Refer100ViewersAchievement',
                'name'          =>  'Refer 100 viewers',
                'description'   =>  'Refer 100 viewers',
                'steps'         =>  100,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Streamer100SubscribeAchievement',
                'name'          =>  'subscribe to 100 streamers',
                'description'   =>  'Subscribe to 100 streamers',
                'steps'         =>  100,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Tweet10Achievement',
                'name'          =>  'tweet 10',
                'description'   =>  'Tweet 10 times',
                'steps'         =>  10,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Tweet20Achievement',
                'name'          =>  'tweet 20',
                'description'   =>  'Tweet 20 times',
                'steps'         =>  20,
                'level_points'  =>  10,
            ],
            [
                'class_name'    =>  'App\Achievements\Tweet50Achievement',
                'name'          =>  'tweet 50',
                'description'   =>  'Tweet 50 times',
                'steps'         =>  50,
                'level_points'  =>  10,
            ],
            [
                'name'          =>  'Speak about StreamCases.tv',
                'description'   =>  'First post on Facebook',
                'steps'         =>  1,
                'level_points'  =>  500,
                'diamonds'      =>  10,
            ],
            [
                'name'          =>  'Tier 2',
                'description'   =>  'Open a Tier 2 StreamCase for the first time',
                'steps'         =>  1,
                'level_points'  =>  0,
                'diamonds'      =>  2,
            ],
            [
                'name'          =>  'Tier 3',
                'description'   =>  'Open a Tier 3 StreamCase for the first time',
                'steps'         =>  1,
                'level_points'  =>  0,
                'diamonds'      =>  5,
            ],
            [
                'name'          =>  'Tier 4',
                'description'   =>  'Open a Tier 4 StreamCase for the first time',
                'steps'         =>  1,
                'level_points'  =>  0,
                'diamonds'      =>  10,
            ],
            [
                'name'          =>  'Tier 5',
                'description'   =>  'Open a Tier 5 StreamCase for the first time',
                'steps'         =>  1,
                'level_points'  =>  0,
                'diamonds'      =>  20,
                'card_rarity_id' => $classes['plain'],
            ],
            [
                'name'          =>  'I am very curious',
                'description'   =>  'Open at least one StreamCase from each Tier 1 to Tier 5',
                'steps'         =>  1,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'card_rarity_id' => $classes['random'],
            ],
            [
                'name'          =>  'Even more generous',
                'description'   =>  'Your Total Donations (Globally) equals at least 10 USD',
                'steps'         =>  10,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'frame_rarity_id' => $classes['random'],
                'case_rarity_id' => $classes['plain'],
            ],
            [
                'name'          =>  'Yet another generous moment',
                'description'   =>  'Your Total Donations (Globally) equals at least 20 USD',
                'steps'         =>  1,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'card_rarity_id' => $classes['random'],
                'case_rarity_id' => $classes['rare'],
            ],
            [
                'name'          =>  'I like donating',
                'description'   =>  'Your Total Donations (Globally) equals at least 50 USD',
                'steps'         =>  50,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'frame_rarity_id' => $classes['rare'],
                'case_rarity_id' => $classes['rare'],
            ],
            [
                'name'          =>  'My new Hobby: Donating!',
                'description'   =>  'Your Total Donations (Globally) equals at least 200 USD',
                'steps'         =>  200,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'frame_rarity_id' => $classes['epic'],
                'case_rarity_id' => $classes['epic'],
            ],
            [
                'name'          =>  'Can not stop donating',
                'description'   =>  'Your Total Donations (Globally) equals at least 500 USD',
                'steps'         =>  500,
                'level_points'  =>  50000,
                'diamonds'      =>  50,
                'frame_rarity_id' => $classes['legendary'],
                'case_rarity_id' => $classes['legendary'],
            ],
            [
                'name'          =>  'Faithful as a Dog',
                'description'   =>  'Subscribe to 2 Channels',
                'steps'         =>  2,
                'level_points'  =>  5000,
                'card_rarity_id' => $classes['plain'],
                'case_rarity_id' => $classes['rare'],
            ],
            [
                'name'          =>  'Faithful as a Penguine',
                'description'   =>  'Subscribe to 5 Channels',
                'steps'         =>  5,
                'level_points'  =>  10000,
                'diamonds'      =>  10,
                'card_rarity_id' => $classes['rare'],
                'case_rarity_id' => $classes['epic'],
            ],
            [
                'name'          =>  'Faithful as a Penguine',
                'description'   =>  'Subscribe to 10 Channels',
                'steps'         =>  10,
                'level_points'  =>  20000,
                'diamonds'      =>  10,
                'card_rarity_id' => $classes['epic'],
                'case_rarity_id' => $classes['legendary'],
            ],
        ];
        foreach ($data as $d) {
            $find = Achievement::where('name', $d)->first();
            if ($find) {
                continue;
            }
            $item = new Achievement();
            $item->class_name = isset($d['class_name']) ? $d['class_name'] : null;
            $item->name = $d['name'];
            $item->description = $d['description'];
            $item->steps = $d['steps'];
            $item->level_points = isset($d['level_points']) ? $d['level_points'] : 0;
            $item->diamonds = isset($d['diamonds']) ? $d['diamonds'] : 0;
            $item->diamonds = isset($d['diamonds']) ? $d['diamonds'] : 0;
            $item->card_rarity_id = isset($d['card_rarity_id']) ? $d['card_rarity_id'] : 0;
            $item->frame_rarity_id = isset($d['frame_rarity_id']) ? $d['frame_rarity_id'] : 0;
            $item->hero_rarity_id = isset($d['hero_rarity_id']) ? $d['hero_rarity_id'] : 0;
            $item->case_rarity_id = isset($d['case_rarity_id']) ? $d['case_rarity_id'] : 0;
            $item->save();
            echo "\n seed id=" . $item->id;
        }
        echo "\n Done \n";
    }

}

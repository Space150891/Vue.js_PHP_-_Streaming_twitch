<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{
    Achievement,
    Activity,
    ActiveStreamer,
    CaseType,
    Item,
    Game,
    HistoryBox,
    Notification,
    Profile,
    RarityClass,
    SignedViewer,
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
    
}

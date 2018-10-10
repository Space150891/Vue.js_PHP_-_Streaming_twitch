<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\{
    Achievement,
    Activity,
    ActiveStreamer,
    CaseType,
    Item,
    Game,
    HistoryBox,
    HistoryBoxItemType,
    Notification,
    Profile,
    RarityClass,
    SignedViewer,
    Streamer,
    SubscribedStreamers,
    User,
    Viewer,
    ViewerCase,
    ViewerItem,
};

class EmulateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emulate {userName} {method}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'emulating events';

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
        $userName = $this->argument('userName');
        $user = User::where('name', $userName)->first();
        if (!$user) {
            exit("user with name {$userName} does not exist");
        }
        $method = $this->argument('method');
        switch ($method) {

            case 'points':
                $this->givePoints($user);
                break;
            case 'following':
                $this->addFollowing($user);
                break;
            case 'notification':
                $this->addNotification($user);
                break;
            case 'boxopen':
                $this->openBox($user);
                break;
            default:
                $this->error("wrong method - <bg=yellow;fg=black> $method </>");
                $this->line("Existing methods:");
                $this->info("points");
                $this->line('   give points to user');
                $this->info("following");
                $this->line('   add random following to user');
                $this->info("notification");
                $this->line('   add notification to user');
                $this->info("boxopen");
                $this->line('   open box');
                $this->line("FORMAT: php artisan emulate <fg=yellow>userName methodName</>");
                break;
        }
    }

    private function givePoints($user)
    {
        $viewer = $user->viewer()->first();
        $viewer->addPoints([
            'points'        =>  1000,
            'title'         => 'WIN!',
            'description'   => 'win points',
            'info'          => 'test points history ',

        ]);
        $this->info("give points to <fg=yellow>{$user->name}</>");
    }

    private function addFollowing($user)
    {
        $viewer = $user->viewer()->first();
        $streamers = Streamer::all();
        $streamerN = rand(0, count($streamers) - 1);
        $streamer = $streamers[$streamerN];
        $signed = new SignedViewer();
        $signed->viewer_id = $viewer->id;
        $signed->streamer_id = $streamer->id;
        $signed->save();
        $this->info("adding random followings to <fg=yellow>{$user->name}</> to streamer <fg=yellow>{$streamer->name}</>");
    }

    private function addNotification($user)
    {
        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->event_type = "user_message";
        $notification->message = "test message";
        $notification->save();
        $this->info("adding message to <fg=yellow>{$user->name}</>");
    }

    private function openBox($user)
    {
        $case = CaseType::first();
        $viewer = $user->viewer()->first();
        // give streamCase to viewer
        $viewerBox = new ViewerCase();
        $viewerBox->viewer_id = $viewer->id;
        $viewerBox->case_id = $case->id;
        $viewerBox->save();
        //
        $history = new HistoryBox();
        $history->viewer_box_id = $viewerBox->id;
        $history->viewer_id = $viewer->id;
        $history->box_type_id = $case->id;
        $historyBoxItemType = HistoryBoxItemType::where('name', 'points')->first();
        $history->item_type_id = $historyBoxItemType->id;
        $history->details = 1000;
        $history->save();
        $this->info("open new box");
    }
    
}

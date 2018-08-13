<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Activity, Item, ViewerItem, Viewer, Streamer, Notification};
use Carbon\Carbon;

class DailyWinerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viewers:daily_winner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select random daily viewer winner';

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
        $today = Carbon::today()->toDateTimeString();
        $tomorrow = Carbon::tomorrow()->toDateTimeString();
        $streams = [];
        $winners = [];
        $activity = Activity::where([
            ['updated_at', '>=', $today],
            ['updated_at', '<=', $tomorrow],
        ])->get();
        foreach ($activity as $act) {
            if (array_key_exists($act->streamer_id, $streams)) {
                $streams[$act->streamer_id][] = $act->viewer_id;
            } else {
                $streams[$act->streamer_id] = [$act->viewer_id];
            }
        }
        $allItems = Item::where('worth', 0)->get();
        foreach ($streams as $streamId => $viewers) {
            // select win viewer
            $randWinner = round(rand(0, count($viewers) - 1));
            $winner = $viewers[$randWinner];
            $winners[] = $winner;
            // select win item
            $randItem = round(rand(0, count($allItems) - 1));
            $item = $allItems[$randItem];
            $viewerItem = new ViewerItem();
            $viewerItem->item_id = $item->id;
            $viewerItem->viewer_id = $winner;
            $viewerItem->save();
            // notification
            $viewer = Viewer::find($winner);
            $user = $viewer->user()->first();
            $streamer = Streamer::find($streamId);
            $notify = new Notification();
            $notify->user_id = $user->id;
            $notify->event_type = 'user_message';
            $message = "You win dialy prize {$item->title} for watching streamer {$streamer->name}";
            $notify->message = $message;
            echo "viewer id={$winner}: " . $message . "\n";
            $notify->save();
        }
    }

}

<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Cashier\Billable;
use Gstt\Achievements\Achiever;
use Illuminate\Support\Carbon;
use App\Models\{
    Achievement,
    AchievementProgres,
    Card,
    CaseType,
    Item,
    ItemType,
    LootCase,
    Notification,
    RarityClass,
    Streamer,
    SubscribedStreamers,
    SubscriptionPlan,
    Viewer,
    ViewerItem,
    ViewerCase
};

class User extends Authenticatable implements JWTSubject
{
    use HasRoleAndPermission;
    use Notifiable;
    use SoftDeletes;
    use Billable;
    use Achiever;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'token',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Build Social Relationships.
     *
     * @var array
     */
    public function social()
    {
        return $this->hasMany('App\Models\Social');
    }

    /**
     * User Profile Relationships.
     *
     * @var array
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    // User Profile Setup - SHould move these to a trait or interface...

    public function profiles()
    {
        return $this->belongsToMany('App\Models\Profile')->withTimestamps();
    }

    public function hasProfile($name)
    {
        foreach ($this->profiles as $profile) {
            if ($profile->name == $name) {
                return true;
            }
        }

        return false;
    }

    public function assignProfile($profile)
    {
        return $this->profiles()->attach($profile);
    }

    public function removeProfile($profile)
    {
        return $this->profiles()->detach($profile);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function viewer()
    {
        return $this->hasOne('App\Models\Viewer');
    }

    public function streamer()
    {
        return $this->hasOne('App\Models\Streamer');
    }

    public function addAchievement($achievementName, $steps = 1)
    {
        $userId = $this->id;
        $achievement = Achievement::where('class_name', $achievementName)->first();
        $progress = AchievementProgres::where([
            ['user_id', '=',  $userId],
            ['achievement_id', '=',  $achievement->id],
        ])->first();
        if (!$progress) {
            $progress = new AchievementProgres();
            $progress->user_id = $userId;
            $progress->achievement_id = $achievement->id;
            $progress->steps = 0;
        }
        if (!is_null($progress->unlocked_at)) {
            return;
        }
        $progress->steps += $steps;
        if ($progress->steps >= $achievement->steps) {
            $progress->unlocked_at = date('Y-m-d H:i:s');
            $viewer = Viewer::where('user_id', $userId)->first();
            $viewer->addPoints([
                'points'    => $achievement->level_points,
                'title'     => 'Achievement',
                'description'   => $achievement->description,
            ]);
            $viewer->diamonds += $achievement->diamonds;
            $viewer->save();
            if ($achievement->card_rarity_id > 0) {
                $frameId = $this->give($achievement->card_rarity_id, 'frame');
                $heroId = $this->give($achievement->card_rarity_id, 'hero');
                if ($frameId > 0 && $heroId > 0) {
                    $card = new Card();
                    $card->viewer_id = $viewer->id;
                    $card->frame_id = $frameId;
                    $card->hero_id = $heroId;
                    $card->achivement_id = $achievement->id;
                    $card->save();
                }
            }
            if ($achievement->frame_rarity_id > 0) {
                $this->give($achievement->frame_rarity_id, 'frame');
            }
            if ($achievement->hero_rarity_id > 0) {
                $this->give($achievement->hero_rarity_id, 'hero');
            }
            if ($achievement->case_rarity_id > 0) {
                $rarityClass = RarityClass::find($achievement->case_rarity_id);
                if ($rarityClass) {
                    $caseType = CaseType::where('rarity_class_id', $achievement->case_rarity_id)->first();
                    $cases = LootCase::where('case_type_id', $caseType->id)->get();
                    if (count($cases) > 0) {
                        $case = $cases[round(rand(0, count($cases) - 1))];
                        $viewerCase = new ViewerCase();
                        $viewerCase->viewer_id = $viewer->id;
                        $viewerCase->case_id = $case->id;
                        $viewerCase->save();
                    }
                }
            }
            $notify = new Notification();
            $notify->user_id = $userId;
            $notify->title = 'Achivement';
            $notify->event_type = 'user_message';
            $notify->message = 'New Achivement! ' . $achievement->description;
            $notify->save();
        }
        $progress->save();
    }

    public function hasAchievement($achievementName)
    {
        $achievement = Achievement::where('class_name', $achievementName)->first();
        $progress = AchievementProgres::where([
            ['user_id', '=',  $this->id],
            ['achievement_id', '=',  $achievement->id],
        ])->whereNotNull('unlocked_at')->first();
        return $progress ? true : false;
    }

    private function give($rarity_id, $itemType)
    {
        $rarityClass = RarityClass::find($rarity_id);
        if (!$rarityClass) {
            return 0;
        }
        $type = ItemType::where('name', $itemType)->first();
        if ($rarityClass->name == 'random') {
            $items = Item::where('item_type_id ', $type->id)->get();
        } else {
            $items = Item::where([
                ['item_type_id', '=', $type->id],
                ['rarity_class_id', '=', $rarity_id],
            ])->get();
        }
        if (count($items) > 0) {
            $viewer = Viewer::where('user_id', $this->id)->first();
            $item = $items[round(rand(0, count($items) - 1))];
            $vItem = new ViewerItem();
            $vItem->viewer_id = $viewer->id;
            $vItem->item_id = $item->id;
            $vItem->save();
            return $vItem->id;
        }
        return 0;
    }

    public function isSubscribed()
    {
        $streamer = Streamer::where('user_id', $this->id)->first();
        $subscription = SubscribedStreamers::where('streamer_id', $streamer->id)->whereDate('valid_until', '>', Carbon::today()->toDateTimeString())->first();
        if ($subscription) {
            $plan = $subscription->subscriptionPlan()->first();
            return $plan->name;
        }
        return false;
    }

}

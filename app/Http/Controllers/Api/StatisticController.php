<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;

use App\Models\{
    Payment,
    ViewerPrize,
    User,
    SubscriptionPlan,
    MonthPlan,
    Diamond,
    Viewer,
    StockPrize
};

class StatisticController extends Controller
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
        $validator = Validator::make($request->all(), [
            'page'       => 'required|numeric|min:1',
            'on_page'     => 'required|numeric|min:1',
            'table'      => 'required|string|min:1',
            'period'     => 'required|string|min:1',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $page = $request->page;
        $message = '';
        $data = [
            'fields'    => [],
            'values'    => [],
            'pages'     => 0,
            'page'      => 0,
        ];
        $filter = [];
        $filter['on_page'] = $request->on_page;
        switch ($request->table) {
            case 'payments':
                $filter['period'] = $request->period;
                $data = $this->loadPaymentsStatistic($page, $filter);
                break;
            case 'winned prizes':
                $filter['period'] = $request->period;
                $data = $this->loadPrizeWinStatistic($page, $filter);
                break;
            default:
                $message = "table not found";
                break;
        }
        return response()->json([
            'data'      => $data,
            'message'   => $message,
        ]);
    }

    private function loadPaymentsStatistic($page, $filter)
    {
        $return = [];
        $total = Payment::whereDate('updated_at', '>=', $this->getPeriodEndDate($filter['period']))->where('status', 'Done')->count();
        $return['pages'] = ceil($total / $filter['on_page']);
        $payments = Payment::whereDate('updated_at', '>=', $this->getPeriodEndDate($filter['period']))
                            ->where('status', 'Done')
                            ->skip(($page - 1) * $filter['on_page'])
                            ->take($filter['on_page'])->get();
        
        $return['values'] = [];
        $return['fields'] = ['User', 'For', 'Details', 'Cost', 'Date'];
        foreach ($payments as $payment) {
            $row = [];
            $user = User::find($payment->user_id);
            $row['User'] = $user->name;
            $row['Date'] = substr($payment->updated_at, 0, 16);
            switch ($payment->type) {
                case 'subscription':
                    $row['For'] = 'subscription';
                    $details = json_decode($payment->details, true);
                    $sPlan = SubscriptionPlan::find($details['subscription_plan_id']);
                    $mPlan = MonthPlan::find($details['month_plan_id']);
                    $row['Cost'] = round($sPlan->cost * $mPlan->monthes * (100 - $mPlan->percent) / 100, 2);
                    $row['Details'] = $sPlan->name . ' for ' . $mPlan->monthes . ' monthes';
                    break;
                case 'buy_diamonds':
                    $row['For'] = 'buy diamonds';
                    $details = json_decode($payment->details, true);
                    $set = Diamond::find($details['diamonds_set_id']);
                    $row['Cost'] = $set->cost;
                    $row['Details'] = $set->amount . ' diamonds';
                    break;
                default:
                    $row['For'] = $payment->type;
                    $row['Cost'] = '-';
                    $row['Details'] = $payment->details;
                    break;
            }
            $return['values'][] = $row;
        }
        $return['page'] = (int) $page;
        return $return;
    }

    private function getPeriodEndDate($period)
    {
        $result = false;
        switch ($period) {
            case 'all':
                $date = new Carbon('1970-01-01 12:00:00');
                $result = $date->toDateTimeString();
                break;
            case 'year':
                $date = new Carbon();
                $date->month(1)->day(1)->hour(0)->minute(0)->second(0);
                $result = $date->toDateTimeString();
                break;
            case 'month':
                $date = new Carbon();
                $date->day(1)->hour(0)->minute(0)->second(0);
                $result = $date->toDateTimeString();
                break;
            case 'day':
                $date = new Carbon();
                $date->hour(0)->minute(0)->second(0);
                $result = $date->toDateTimeString();
                break;
        }
        return $result;
    }

    private function loadPrizeWinStatistic($page, $filter)
    {
        $return = [];
        $return['page'] = (int) $page;
        $total = ViewerPrize::whereDate('updated_at', '>=', $this->getPeriodEndDate($filter['period']))->count();
        $return['pages'] = ceil($total / $filter['on_page']);
        $return['values'] = [];
        $return['fields'] = ['User', 'Prize', 'Cost', 'Date'];
        $prizes = ViewerPrize::whereDate('updated_at', '>=', $this->getPeriodEndDate($filter['period']))
                    ->skip(($page - 1) * $filter['on_page'])
                    ->take($filter['on_page'])->get();
        foreach ($prizes as $prize) {
            $row = [];
            $viewer = Viewer::find($prize->viewer_id);
            $row['User'] = $viewer->name;
            $row['Date'] = substr($prize->updated_at, 0, 16);
            $stockPrize = StockPrize::find($prize->prize_id);
            $row['Prize'] = $stockPrize->name;
            $row['Cost'] = $stockPrize->cost;
            $return['values'][] = $row;
        }
        return $return;
    }
}

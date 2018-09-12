<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function subscribe (Request $request){
        //found user which want to subscribed
        $user = User::find($request->user_id);
        if($user){
            //subscribed that user on plan what he want
            //newSubscription - this is Laravel Cashier packet for subscription in Stripe

            if($request->discount){
                $res = $user->newSubscription('main',$request->plan)
                    ->withCoupon($request->discount)
                    ->create($request->token['id']);
            }else{
                $res = $user->newSubscription('main',$request->plan)
                    ->create($request->token['id']);
            }

            return response()->json($res);
        }else{
            return response()->json(['error'=>'user not found!'],500);
        }

    }
}

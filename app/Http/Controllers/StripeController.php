<?php

namespace App\Http\Controllers;
use Log;
use Illuminate\Http\Request;


class StripeController extends Controller
{

public function signUp(Request $request){
  Log::info('Request: ', $request->all());
  \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
//$name = explode(" ", $request->name);
$account = \Stripe\Account::create(
  array(
    "country" => "US",
    "managed" => true,
    "email" => $request->email,
    "legal_entity" =>[
    "first_name" =>$request->firstname,
    "last_name" =>$request->lastname,
    "type" => 'individual',
    'dob' =>[
     'day' => $request->day,
      'month' =>$request->month,
      'year' => $request->year
      ],
      "personal_address"=> [
        "city" => $request->city,
        "country" => "US",
         "line1" => $request->line_1,
         "line2" => $request->line_2,
         "postal_code" => $request->zip,
         "state" => $request->state
        ],
        "ssn_last_4" => $request->ssn_last_4,
      ],

      "tos_acceptance" => [
        "date" => time(),
        "ip" => $request->ip(),
        "user_agent" => $request->header('User-Agent')
        ],
    array("external_account" => $request->token,

  ),
  )
 );
 return response()->json([
   'id' =>$account->id,
   'secret' =>$account->keys['secret']
 ]);

}
public function charge(Request $request){
Log::info('Request: ',$request->all());
  \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
$charge = \Stripe\Charge::create(array(
  "amount" => $request->input('amount'),
  "currency" => "usd",
  "source" => $request->token,
  "description" => $request->input('description'),
  "application_fee" => 50,
  "destination" => $request->account_id
    ));
return $charge;
}

public function createPlan(Request $request){
  \Stripe\Stripe::setApiKey($request->secret_key);

$plan = \Stripe\Plan::create(array(
"amount" => $request->amount,
"interval" => $request->interval,
"name" => $request->name,
"currency" => "usd",
"id" => $request->plan_id)
);

return $plan;
}

public function createSubscription(Request $request){
  \Stripe\Stripe::setApiKey($request->secret_key);

$customer = \Stripe\Customer::create(array(
  "description" => "Customer for {$request->email}",
  "source" => $request->stripe_token, // obtained with Stripe.js
  "plan" => $request->plan
));

return $customer;
}

}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('index');
});

$app->post('stripe', function (Request $request) {
  switch($request->type){
    case 'charge.succeeded':
     $number = $request->data['object']['amount'] / 100;
    Mail::raw('Charge succeeded in amount of $'. money_format('%i', $number) . "\n",
    function($msg) {
      $msg->to(['8594024863@messaging.sprintpcs.com']);
       $msg->from(['payment@jyroneparker.com']);
     });
     break;
     case 'charge.failed':
     $number = $request->data['object']['amount'] / 100;
    Mail::raw('Charge failed in amount of $'. money_format('%i', $number) . "\n",
    function($msg) {
      $msg->to(['8594024863@messaging.sprintpcs.com']);
       $msg->from(['payment@jyroneparker.com']);
     });
     break;
   }
});

$app-> post('charge',['middleware' => 'cors', function(Request $request){
  //dd($request);
  \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
\Stripe\Charge::create(array(
  "amount" => $request->input('amount'),
  "currency" => "usd",
  "source" => $request->token,
  "description" => $request->input('description')
));
return response()->json(['success'=>'true']);
}]);

<?php

use Illuminate\Http\Request;
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
    return 'Parker POS';
});

$app-> post('charge',['middleware' => 'cors', function(Request $request){
  \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
\Stripe\Charge::create(array(
  "amount" => $request->amount,
  "currency" => "usd",
  "source" => [
    'exp_month' => $request->exp_month,
    'exp_year' => $request->exp_year,
    'number' => $request->card_number,
    'object' => 'card',
    'cvc' => $request->cvc
    ], // obtained with Stripe.js
  "description" => $request->description
));
}]);

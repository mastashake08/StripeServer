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
    return view('index');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ChargeController extends Controller
{

  
public function charge(Request $request){

  \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
\Stripe\Charge::create(array(
  "amount" => $request->input('amount'),
  "currency" => "usd",
  "source" => $request->token,
  "description" => $request->input('description')
));
return response()->json(['success'=>'true']);
}

}

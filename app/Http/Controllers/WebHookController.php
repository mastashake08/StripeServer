<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebHookController extends Controller
{

public function handleStripe(Request $request){
  switch($request->type){
    case 'charge.succeeded':
     $number = $request->data['object']['amount'] / 100;
    Mail::raw('Charge succeeded in amount of $'. money_format('%i', $number) . "\n",
    function($msg) {
      $msg->to([env('PHONE_ADDRESS')]);
       $msg->from([[env('MAIL_FROM_ADDRESS')]);
     });
     break;
     case 'charge.failed':
     $number = $request->data['object']['amount'] / 100;
    Mail::raw('Charge failed in amount of $'. money_format('%i', $number) . "\n",
    function($msg) {
      $msg->to([[env('PHONE_ADDRESS')]);
       $msg->from([[env('MAIL_FROM_ADDRESS')]);
     });
     break;
   }
}

}

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
       $msg->from([env('MAIL_FROM_ADDRESS')]);
     });
     break;
     case 'charge.failed':
     $number = $request->data['object']['amount'] / 100;
    Mail::raw('Charge failed in amount of $'. money_format('%i', $number) . "\n",
    function($msg) {
      $msg->to([env('PHONE_ADDRESS')]);
       $msg->from([env('MAIL_FROM_ADDRESS')]);
     });
     break;
   }
}

public function handleGithub(Request $request){
  //dd($request->head_commit);
    Mail::raw("There is a new push to the project {$request->repository['name']} id: {$request->head_commit['id']} by {$request->head_commit['committer']['name']}."  ,
    function($msg) {
      $msg->to('8594024863@messaging.sprintpcs.com');
      $msg->cc('5026441212@tmomail.net');
       $msg->from('jyrone.parker@gmail.com');
     });

   }
}

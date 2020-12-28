<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Plan;
use App\Subscription;
use App\Http\Requests\CreateBuyLicenseRequest;

class SubscriptionController extends Controller
{
    function getTrelloBoard($license_key) {

        $responses = Subscription::where('license_key', $license_key)->get(); 

        // foreach( $responses as $response ) {
        //     echo $response->trello_board.'<br>';
        // }

        // exit;

        return $responses[0]->trello_board;

    }

    public function editTrello(Request $request) {
        $edited_data_id = $request->edited_id;
        $edited_data = $request->edited_data;

        $subscription = Subscription::find( $edited_data_id );
        $subscription->trello_board = $edited_data;

        $subscription->push();
        
        return 'success';

    }

    public function generatePassword($length) {
        $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRESTUVWXYZ_"; // allowed chars in the password
        if ($length == "" OR !is_numeric($length)){
            $length = 8; 
        }
    
        $i = 0; 
        $password = "";    
        while ($i < $length) { 
            $char = substr($possible, rand(0, strlen($possible)-1), 1);
            if (!strstr($password, $char)) { 
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }
    public function create(CreateBuyLicenseRequest $request, Plan $plan)
    {
        // if($request->user()->subscribedToPlan($plan->stripe_plan, 'main')) {
        //     return redirect()->route('home')->with('success', 'You have already subscribed the plan');
        // }
        
        $plan = Plan::findOrFail($request->get('plan'));
        
        $sub_result = $request->user()
            ->newSubscription('main', $plan->stripe_plan)
            ->create($request->stripeToken);

        $trello_board_1 = $request['trello_board_1'];
        $trello_board_2 = $request['trello_board_2'];
        $trello_board = $trello_board_1.','.$trello_board_2 ;
        $license_key = $this->generatePassword(12);
        $stripe_id = $sub_result["stripe_id"];

        $affected = DB::table('subscriptions')
              ->where('stripe_id', $stripe_id)
              ->update(['trello_board' => $trello_board, 'license_key' => $license_key]);
              
        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }
}

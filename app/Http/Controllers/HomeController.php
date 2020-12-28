<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Subscription;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(Auth::check()) {
            $subscriptions = Subscription::where('user_id', Auth::id() )->get();
            return view('home', ['subscriptions' => $subscriptions ]);
        }
        else {
            return view('home');
        }
    }
}

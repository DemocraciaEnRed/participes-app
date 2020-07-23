<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Forces to be authenticated.
        $this->middleware('auth');
        $this->middleware('check_role:user');
    }

    public function markOneRead(Request $request, $id){
      $notification = $request->user()->unreadNotifications->where('id', $id)->first();
      if($notification){
        $notification->markAsRead();
        response()->json(['message' => 'Ok'], 200); 
      }
      response()->json(['message' => 'Not found'], 404); 
    }
    public function markAllRead(Request $request, $id){
        
    }

}

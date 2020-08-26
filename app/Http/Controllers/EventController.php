<?php

namespace App\Http\Controllers;
use Image;
use Storage;
use Log;
use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function __construct()
    {
        
    }

    private function hasManagerPrivileges(Request $request){
      if(!$request->user()->hasRole('admin') && !$request->user()->isManagerObjective($request->objective->id)){
        return response()->json(['message' => 'Not authorized'],403);
      }
      return;
    }

    public function showUpcomingEvents(Request $request){
      $events = Event::where('date', '>=', Carbon::today())->orderBy('date','ASC')->paginate(6);
      
      return view('portal.events.upcoming',[
            'events' => $events,
        ]);
    }
    public function showPastEvents(Request $request){
      $events = Event::where('date', '<', Carbon::today())->orderBy('date','ASC')->paginate(6);

      return view('portal.events.past',[
            'events' => $events,
        ]);
    }

    public function index(Request $request, $eventId){
        $event = Event::findorfail($eventId);
        return view('portal.events.view',[
            'event' => $event,
        ]);
    }

}
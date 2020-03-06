<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Event extends Controller
{
    //
    private $evt;

    function __construct()
    {
        $this->evt = new Events();
    }

    ################### SHOW EVENTS ##################### 
    function showEvents(){
        return $this->evt::all()->where('status',0)->toArray();
        
    }
    
    ################### DELETE EVENT ###################### 
    function deleteEvent($id){
        $currentDate = date('d-m-y');
        $event = DB::table('events')->select('total_seat','avalable_sit','eventName')
        ->where('eventId','=',$id)
        ->where('event_date','>',$currentDate)
        ->get();
        $event_name = $event[0]->eventName;
        $isEqualsit = $event[0]->total_seat==$event[0]->avalable_sit?true:false;

        if($isEqualsit){
            // DB::delete('delete from events where eventId = ?', [$id]);
            DB::update('update events set status = true where eventId = ?', [$id],"avalable_sit",'<',"total_seat");
            return response()->json(
                array(
                    'id'=> (int)$id,
                    'event_name' => $event_name,
                    'current_date'=>$currentDate,
                    'event_date'=>'',
                    'message'=> 'deleted successfuly'
                )
            );
        }else{
            return response()->json(array(
                'id' => 0,
                'message' => 'event not found ',
            ));
        }
        
    }
}

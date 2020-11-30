<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function createEvent($id)
    {
       $data = [];
       $event = Event::where(['id' => $id])->first();

        $event->update([ 
            'workout_id' => $id,
            'user_id' => 2,
            'title' => "blablub",
            'start' => "",
            'end' => ""
            
        ]);
       
        $event->save();
        return;
    }  
}

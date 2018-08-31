<?php

namespace App\Http\Controllers\Api;

use App\Point;
use App\Workout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dump('indexing');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = '';
        $hours = Carbon::now()->format('H');
        if(  $hours < 12 ){
            $title = 'Morning ';
        } else if( $hours < 19 ){
            $title = 'Afternoon ';
        }
        else if( $hours < 23  ){
            $title = 'Evening  ';
        };

        $title .= $request->type == Workout::TYPE_CYCLING ? 'ride' : 'run';

        $firstPoint = $request->points[0] ?? [];
        $utcTime = Carbon::createFromTimeString( $firstPoint['time'], Auth::user()->timezone );

        $workout = [
            'title' => $title,
            'type' => $request->type,
            'user_id' => Auth::id(),
            'time' => $utcTime->setTimezone('UTC')->toDateTimeString(),
            'status' => Workout::STATUS_ACTIVE
        ];

        $workout = Workout::create( $workout );

        foreach( $request->points as $point ){

            $utcTime = Carbon::createFromTimeString( $point['time'], Auth::user()->timezone );

            $points[] = new Point([
                'workout_id' => $workout->id,
                'segment_index' => $point['segment_index'],
                'coordinates' => new \App\Utilities\WorkoutImport\Point($point['lat'],$point['lng']),
                'heart_rate' => $point['heart_rate'],
                'elevation' => $point['elevation'],
                'time' => $utcTime->setTimezone('UTC')->toDateTimeString()
            ]);
        }

        $workout->points()->saveMany( $points );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workout = Workout::with('points')
            ->where(['id' => $id] )
            ->first();

        return $workout;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

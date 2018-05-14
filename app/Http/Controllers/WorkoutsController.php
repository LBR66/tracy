<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workout;
use App\Point;
use Illuminate\Support\Facades\Auth;
use App\Utilities\WorkoutImport\Parsers\Gpx;
use Illuminate\Support\Facades\DB;


class WorkoutsController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workouts = Workout::with('points')->orderBy( 'created_at', 'desc')->get();

        return view( 'workouts.index' , compact( 'workouts' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Gpx $gpx
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Gpx $gpx)
    {
        $path = $request->workout_file->storeAs('workouts', $request->workout_file->getClientOriginalName());

        $path = storage_path('app/' . $path);
        $data = $gpx->parse($path);

        $workout = [
            'title' => $gpx->getType() ?? 'New workout',
            'import_filename' => $path,
            'user_id' => Auth::id()
        ];

        $workout = Workout::create( $workout );

        $points = [];

        foreach( $gpx as $point ){
            $points[] = new Point([
               'workout_id' => $workout->id,
                'coordinates' => $point,
                'heart_rate' => $point->getHeartRate(),
                'elevation' => $point->getEvelation(),
                'time' => $point->getTime()
            ]);
        }

        $workout->points()->saveMany( $points );

        return redirect( '/workouts' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

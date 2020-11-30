<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTriggerWorkouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(' 
        create trigger tr_DeleteTriggerWorkouts AFTER DELETE ON workouts FOR EACH ROW
            DELETE FROM events
            WHERE events.workout_id= workouts.id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      DB::unprepared('DROP TRIGGER `tr_DeleteTriggerWorkouts`');
    }
}

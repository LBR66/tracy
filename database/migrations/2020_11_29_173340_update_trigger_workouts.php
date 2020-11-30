<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTriggerWorkouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        create trigger tr_UpdateTriggerWorkouts AFTER UPDATE ON workouts FOR EACH ROW
            UPDATE events a
            INNER JOIN workouts b ON a.workout_id = b.id
            SET a.title = b.title;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_UpdateTriggerWorkouts`');
      
    }
}

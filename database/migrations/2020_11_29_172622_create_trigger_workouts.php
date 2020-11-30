<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggerWorkouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        
        create trigger tr_CreateTriggerWorkouts AFTER INSERT ON workouts FOR EACH ROW
        INSERT INTO events (
            workout_id, 
            user_id, 
            title,
            start,
            end
        )
        SELECT 
            id, 
            user_id, 
            title,
            time,
            time
        FROM 
            workouts
        WHERE 
            id = NEW.id;
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        DB::unprepared('DROP TRIGGER `tr_CreateTriggerWorkouts`');
    }
}

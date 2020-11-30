<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventsUserWorkoutIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::table('events', function (Blueprint $table) {
        $table->integer('user_id')->after('id')->nullable();//
            $table->integer('workout_id')->after('id')->nullable();//
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('events', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('workout_id');
        });//
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkoutsSomeFields2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workouts', function (Blueprint $table) {
      $table->float('altmeter')->after('elevation')->nullable(true);
		  $table->float('increase')->after('altmeter')->nullable(true);
		  $table->float('descent')->after('increase')->nullable(true);
		 
		}
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {	
		Schema::table('workouts', function (Blueprint $table) {
         $table->dropColumn('altmeter');
         $table->dropColumn('increase');
         $table->dropColumn('descent');
		}
    );
	}
}

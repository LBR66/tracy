<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkoutsSomeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
      Schema::table('workouts', function (Blueprint $table) {
      $table->float('distance')->after('time')->nullable(true);       
      $table->float('elevation')->after('distance')->nullable(true);         
		  $table->float('avg_power')->after('elevation')->nullable(true);
		  $table->float('max_power')->after('avg_power')->nullable(true);
		  $table->float('avg_hr')->after('max_power')->nullable(true);
		  $table->float('max_hr')->after('avg_hr')->nullable(true);
		  $table->float('avg_cad')->after('max_hr')->nullable(true);
      $table->float('max_cad')->after('avg_cad')->nullable(true);
      $table->float('energy')->after('max_cad')->nullable(true);
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
         $table->dropColumn('distance');
         $table->dropColumn('elevation');
         $table->dropColumn('avg_power');
         $table->dropColumn('max_power');
		     $table->dropColumn('avg_hr');
         $table->dropColumn('max_hr');
		     $table->dropColumn('avg_cad');
         $table->dropColumn('max_cad');
         $table->dropColumn('energy');   
		}
    );
	}
}

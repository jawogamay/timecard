<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLunchbreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lunchbreaks', function (Blueprint $table) {
            $table->increments('id');
             $table->timestamp('started_at');
            $table->timestamp('stopped_at')->nullable();
            $table->unsignedInteger('schedule_id');
            $table->unsignedInteger('userinfo_id');
            $table->boolean('overbreak')->default(FALSE);
            $table->unsignedInteger('timecard_id');
            $table->timestamp('time_outexpire');
            $table->double('hours')->default(0);
            $table->double('minutes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lunchbreaks');
    }
}

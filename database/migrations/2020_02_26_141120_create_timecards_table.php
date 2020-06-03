<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timecards', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('time_in');
            $table->timestamp('time_out')->nullable();
            /*$table->unsignedInteger('firstbreak_id')->nullable();
            $table->unsignedInteger('lunchbreak_id')->nullable();
            $table->unsignedInteger('lastbreak_id')->nullable();*/
            $table->boolean('work_flag')->default(FALSE);
            $table->boolean('late_flag')->default(FALSE);
            $table->boolean('is_working')->default(FALSE);
            $table->boolean('done_fbreak')->default(FALSE);
            $table->boolean('done_lunch')->default(FALSE);
            $table->boolean('done_lbreak')->default(FALSE);
            $table->timestamp('fbreak_out')->nullable();
         /*   $table->unsignedInteger('user_id');*/
            $table->boolean('overbreak')->default(FALSE);
            $table->timestamp('time_outexpire');
            $table->unsignedInteger('userinfo_id');
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
        Schema::dropIfExists('timecards');
    }
}

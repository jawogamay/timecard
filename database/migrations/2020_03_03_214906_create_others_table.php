<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('others', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('userinfo_id');
            $table->unsignedInteger('timecard_id');
            $table->timestamp('started_at');
            $table->timestamp('stopped_at')->nullable();
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
        Schema::dropIfExists('others');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
            $table->string('title',250);
            $table->text('content');    
            $table->string('gps_lat',50);        
            $table->string('gps_lng',50);      
            $table->unsignedInteger('user_id');  
            $table->timestamps();
            $table->foreign('user_id')
            ->references('id')
            ->on('users');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

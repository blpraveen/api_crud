<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nick_name',250);
            $table->text('content');
            $table->unsignedInteger('news_id')->nullable();
            $table->unsignedInteger('events_id')->nullable();
            $table->timestamps();
            $table->foreign('news_id')
            ->references('id')
            ->on('news');
            $table->foreign('events_id')
            ->references('id')
            ->on('events');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

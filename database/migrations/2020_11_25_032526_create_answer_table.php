<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_result')->unsigned();
            $table->bigInteger('id_question')->unsigned();
            $table->string('answer');
            $table->string('question');
            $table->timestamps();
            $table->foreign('id_result')->references('id')->on('result');
            $table->foreign('id_question')->references('id')->on('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer');
    }
}

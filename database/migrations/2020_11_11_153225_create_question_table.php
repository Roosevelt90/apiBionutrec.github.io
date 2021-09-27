<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_survey')->unsigned();
            $table->bigInteger('id_type')->unsigned();
            $table->string('name');
            $table->string('name_id');
            $table->integer('required')->default(0);
            $table->integer('header')->default(0);
            $table->string('values')->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();

            $table->foreign('id_survey')->references('id')->on('survey');
            $table->foreign('id_type')->references('id')->on('type_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question');
    }
}

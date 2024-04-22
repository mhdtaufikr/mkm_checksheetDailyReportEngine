<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetsTables extends Migration
{
    public function up()
    {
        Schema::create('checksheets_header', function (Blueprint $table) {
            $table->id();
            $table->string('dept');
            $table->string('section');
            $table->date('date');
            $table->string('shift');
            $table->integer('revision');
            $table->string('no_document');
            $table->timestamps();
        });

        Schema::create('checksheets_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_checksheet');
            $table->foreign('id_checksheet')->references('id')->on('checksheets_header')->onDelete('cascade');
            $table->string('shop');
            $table->string('model');
            $table->integer('mp_plan');
            $table->integer('mp_actual');
            $table->integer('prod_plan');
            $table->integer('prod_actual');
            $table->integer('prod_diff');
            $table->string('problem');
            $table->string('cause');
            $table->string('action');
            $table->time('time');
            $table->string('pic');
            $table->timestamps();
        });

        Schema::create('shop_master', function (Blueprint $table) {
            $table->id();
            $table->string('shop');
            $table->string('model');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checksheets_detail');
        Schema::dropIfExists('checksheets_header');
        Schema::dropIfExists('shop_master');
    }
}

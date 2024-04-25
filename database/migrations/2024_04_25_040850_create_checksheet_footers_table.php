<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetFootersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_footers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_checksheetdtl');
            $table->foreign('id_checksheetdtl')->references('id')->on('checksheet_details')->onDelete('cascade');
            $table->string('model', 255);
            $table->integer('prod_plan');
            $table->integer('prod_actual');
            $table->integer('prod_diff');
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
        Schema::dropIfExists('checksheet_footers');
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('description', 125)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('plan_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id');
            $table->string('attribute');
            $table->enum('type', ['check', 'reply'])->comment('check/reply');
            $table->string('op', 2)->default(':=');
            $table->string('value', 145);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
        Schema::dropIfExists('plan_details');
    }
}

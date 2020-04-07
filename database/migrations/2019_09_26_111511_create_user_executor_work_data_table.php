<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExecutorWorkDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_executor_work_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('legal_type');
            $table->string('team_type');
            $table->string('brigade_size')->nullable();
            $table->string('about')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('main_city_id')->index()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('main_city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_executor_work_data');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_portfolio_albums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->unsignedBigInteger('preview_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_portfolio_album_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->string('crop')->nullable();
            $table->unsignedBigInteger('album_id')->nullable();
            $table->foreign('album_id')->references('id')->on('user_portfolio_albums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_portfolio_album_photos');
        Schema::dropIfExists('user_portfolio_albums');
    }
}

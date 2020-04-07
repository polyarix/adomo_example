<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->string('crop')->nullable();
            $table->text('description')->nullable();

            $table->integer('morph_id')->nullable();
            $table->string('morph_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_videos');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('image');
            $table->unsignedInteger('depth')->default(1);
            $table->unsignedInteger('lft')->default(0);
            $table->unsignedInteger('rgt')->default(0);
            $table->unsignedInteger('parent_id')->nullable();

            $table->boolean('is_visible')->default(false);
            $table->string('type')->default(\App\Entity\Common\Slider::TYPE_MAIN_PAGE);
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
        Schema::dropIfExists('sliders');
    }
}

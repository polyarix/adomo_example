<?php

use App\Entity\Location\City;
use App\Entity\Location\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create((new City())->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('region_id')->nullable();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->timestamps();

            //$table->unique(['name', 'region_id']);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new City())->getTable());
    }
}

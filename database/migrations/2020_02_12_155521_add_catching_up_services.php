<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCatchingUpServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advert_services', function (Blueprint $table) {
            $table->dateTime('catched_up_to')->nullable();
        });
        Schema::table('advert_orders', function (Blueprint $table) {
            $table->dateTime('catched_up_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advert_services', function (Blueprint $table) {
            $table->dropColumn('catched_up_to');
        });
        Schema::table('advert_orders', function (Blueprint $table) {
            $table->dropColumn('catched_up_to');
        });
    }
}

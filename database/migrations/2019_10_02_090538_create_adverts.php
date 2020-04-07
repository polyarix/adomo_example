<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity\Advert\Advert\Order;

class CreateAdverts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');

            $table->integer('price')->nullable();
            $table->string('price_type')->default(Order::PRICE_TYPE_SPECIFIC);
            $table->string('time_type')->default(Order::TIME_TYPE_ANY);
            $table->string('address')->nullable();
            $table->date('beginning_date')->nullable();
            $table->string('map_address')->nullable();
            $table->decimal('map_lat', 10, 8)->nullable();
            $table->decimal('map_long', 11, 8)->nullable();
            $table->boolean('house_provision')->default(false);
            $table->boolean('materials_provision')->default(false);
            $table->string('status')->default(Order::STATUS_MODERATION);
            $table->string('close_reason')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('moderated_at')->nullable();
            $table->timestamps();

            $table->string('slug')->unique();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            //$table->foreign('category_id')->references('id')->on('advert_categories')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        Schema::create('advert_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path')->nullable();
            $table->string('crop')->nullable();
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
        Schema::dropIfExists('advert_orders');
        Schema::dropIfExists('advert_photos');
    }
}

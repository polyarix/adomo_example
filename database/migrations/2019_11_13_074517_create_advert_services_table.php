<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity\Advert\Advert\Service;

class CreateAdvertServicesTable extends Migration
{
    public function up()
    {
        Schema::create('advert_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id')->nullable();

            $table->integer('price')->nullable();
            $table->string('price_type')->default(Service::PRICE_TYPE_SPECIFIC);
            $table->string('status')->default(Service::STATUS_MODERATION);
            $table->string('close_reason')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('moderated_at')->nullable();
            $table->timestamps();

            $table->string('slug')->unique();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->integer('views')->default(0);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        Schema::create('advert_service_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('service_id');

            $table->foreign('category_id')->references('id')->on('advert_categories')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('advert_services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('advert_service_categories');
        Schema::dropIfExists('advert_services');
    }
}

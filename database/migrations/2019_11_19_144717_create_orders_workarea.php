<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersWorkarea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_order_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');

            $table->text('message')->nullable();
            $table->string('status')->default(\App\Entity\Advert\Advert\Order\Request::STATUS_WAITING);
            $table->boolean('customer_invite')->default(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('advert_orders')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('advert_order_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('text');
            $table->string('type');
            $table->integer('quality')->nullable();
            $table->integer('professionalism')->nullable();
            $table->integer('punctuality')->nullable();
            $table->integer('avg')->nullable();
            $table->boolean('recommended')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('order_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('advert_orders')->onDelete('cascade');

            $table->timestamps();
        });

        // add executor_id
        Schema::table('advert_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('executor_id')->nullable();
            $table->string('tyme_type')->default(\App\Entity\Advert\Advert\Order::TIME_TYPE_ANY);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_order_requests');
        Schema::dropIfExists('advert_order_reviews');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('passport_series');
            $table->dropColumn('executor_id');
        });
    }
}

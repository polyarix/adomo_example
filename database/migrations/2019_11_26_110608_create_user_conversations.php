<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
Use Illuminate\Database\Schema\Blueprint;

class CreateUserConversations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('chat_conversations');
        Schema::dropIfExists('chat_messages');

        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_one');
            $table->unsignedBigInteger('user_two');
            $table->boolean('status');
            $table->string('theme');

            $table->unsignedBigInteger('order_id')->nullable();

            $table->timestamps();

            $table->foreign('user_one')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_two')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('advert_orders')->onDelete('cascade');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message');
            $table->boolean('is_seen')->default(0);
            $table->boolean('deleted_from_sender')->default(0);
            $table->boolean('deleted_from_receiver')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('conversation_id');
            $table->string('type')->default(\App\Entity\User\Conversation\Message::TYPE_MESSAGE);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('conversation_id')->references('id')->on('chat_conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_conversations');
        Schema::dropIfExists('chat_messages');
    }
}

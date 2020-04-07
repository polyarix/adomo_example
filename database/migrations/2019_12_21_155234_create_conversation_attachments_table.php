<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_conversation_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->string('mime');
            $table->string('path');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('message_id')->nullable();
            $table->timestamps();

            $table->foreign('message_id')->references('id')->on('chat_messages')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_conversation_attachments');
    }
}

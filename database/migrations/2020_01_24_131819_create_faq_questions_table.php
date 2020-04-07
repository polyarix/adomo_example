<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_questions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->text('text');
            $table->string('group_title')->nullable();
            $table->string('group')->nullable();

            $table->unsignedInteger('depth')->default(1);
            $table->unsignedInteger('lft')->default(0);
            $table->unsignedInteger('rgt')->default(0);
            $table->unsignedInteger('parent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_questions');
    }
}

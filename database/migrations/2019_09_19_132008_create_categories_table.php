<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('advert_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('breadcrumb_name')->nullable();
            $table->boolean('is_visible')->default(true);

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('seo_text')->nullable();

            $table->unsignedInteger('depth')->default(1);
            $table->unsignedInteger('lft')->default(0);
            $table->unsignedInteger('rgt')->default(0);
            $table->unsignedInteger('parent_id')->nullable();

            $table->timestamps();

            //$table->foreign('parent_id')->references('id')->on('advert_categories');
        });
        DB::statement("ALTER TABLE advert_categories ADD image TEXT");

        Schema::create('category_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
        });

        Schema::create('category_categories_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('category_id')->references('id')->on('advert_categories')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('category_tags')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_tags');
        Schema::dropIfExists('category_categories_tags');
    }
}

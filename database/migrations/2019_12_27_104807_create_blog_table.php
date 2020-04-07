<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->timestamps();

            SeoHelper::migration($table);
        });

        Schema::create('blog_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->mediumText('content');
            $table->string('slug')->unique();
            $table->boolean('is_visible')->default(false);
            $table->integer('views')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();

            SeoHelper::migration($table);
        });

        Schema::create('blog_article_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('article_id')->references('id')->on('blog_articles')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });

        Schema::create('blog_article_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('text');
            $table->string('status')->default(\App\Entity\Blog\Comment::STATUS_MODERATION);
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('blog_articles')->onDelete('cascade');
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
        Schema::dropIfExists('blog_article_categories');
        Schema::dropIfExists('blog_article_comments');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_articles');
    }
}

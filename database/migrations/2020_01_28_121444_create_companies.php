<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;

class CreateCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');

            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->string('workers_count')->nullable();

            $table->string('slug')->unique();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        // Company categories
        Schema::create('company_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('company_id');

            $table->foreign('category_id')->references('id')->on('advert_categories')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        // Company contacts
        Schema::create('company_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address');
            $table->text('contacts');
            $table->text('schedule');
            $table->decimal('map_lat', 10, 8)->nullable();
            $table->decimal('map_long', 11, 8)->nullable();
            $table->unsignedBigInteger('company_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        // Company blog
        Schema::create('company_blog_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->mediumText('content');
            $table->string('slug')->unique();
            $table->boolean('is_visible')->default(false);
            $table->integer('views')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            SeoHelper::migration($table, [SeoHelper::FIELD_SEO_TEXT, SeoHelper::FIELD_BREADCRUMB_NAME]);
        });

        // Company portfolio
        Schema::create('company_works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->mediumText('description');
            $table->integer('price')->nullable();
            $table->integer('duration')->nullable();
            $table->string('duration_type')->nullable();
            $table->integer('preview_id')->nullable();

            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('company_work_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path')->nullable();
            $table->string('crop')->nullable();
            $table->integer('work_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_categories');
        Schema::dropIfExists('company_contacts');
        Schema::dropIfExists('company_blog_articles');
        Schema::dropIfExists('company_work_photos');
        Schema::dropIfExists('company_works');
        Schema::dropIfExists('companies');
    }
}

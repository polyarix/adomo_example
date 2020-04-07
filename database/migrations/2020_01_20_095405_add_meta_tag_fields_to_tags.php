<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Services\Infrastructure\Seo\SeoHelper;

class AddMetaTagFieldsToTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_tags', function (Blueprint $table) {
            SeoHelper::migration($table);
        });
        DB::statement("ALTER TABLE category_tags ADD image TEXT");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_tags', function (Blueprint $table) {
            SeoHelper::rollbackMigration($table);
        });
    }
}

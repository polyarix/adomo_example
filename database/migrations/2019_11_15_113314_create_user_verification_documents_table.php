<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity\User\Verification\Document;

class CreateUserVerificationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verification_documents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');

            $table->string('path');
            $table->string('crop');
            $table->string('type');
            $table->boolean('public')->default(false);
            $table->string('status')->default(Document::STATUS_WAIT);

            $table->string('reject_reason')->nullable();
            $table->dateTime('status_changed_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('passport_series')->nullable();
            $table->string('registration')->nullable();
            $table->boolean('criminal_record')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_verification_documents');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('passport_series');
            $table->dropColumn('registration');
            $table->dropColumn('criminal_record');
        });
    }
}

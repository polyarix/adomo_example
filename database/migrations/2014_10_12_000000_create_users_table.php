<?php

use App\Entity\User\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('sex')->nullable();
            $table->string('birth_date')->nullable();
            $table->text('about')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_email_code')->nullable();

            $table->dateTime('phone_verified_at')->nullable();
            $table->string('verification_phone_code')->nullable();
            $table->dateTime('phone_code_expires')->nullable();

            $table->unsignedBigInteger('city_id')->nullable();

            $table->string('password')->nullable();
            $table->string('type');
            $table->string('role')->default(User::ROLE_USER);
            $table->string('status')->default(User::STATUS_NEW);
            $table->string('photo')->nullable();
            $table->string('rating')->nullable();

            $table->dateTime('banned_at')->nullable();
            $table->dateTime('banned_to')->nullable();
            $table->string('ban_reason')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        Schema::create('user_networks', function (Blueprint $table) {
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('network');
            $table->string('identity');
            $table->primary(['user_id', 'identity']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_networks');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity\Contact\Contact;

class CreateContactRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->text('text');
            $table->string('type')->default(Contact::TYPE_REQUEST);
            $table->boolean('viewed')->default(false);

            $table->string('status')->default(Contact::STATUS_NEW);
            $table->text('response_text')->nullable();
            $table->dateTime('respond_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_requests');
    }
}

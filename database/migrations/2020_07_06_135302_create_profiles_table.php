<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('place')->nullable();
            $table->string('job')->nullable();
            $table->string('personal_id')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_dob')->nullable();
            $table->string('detail')->nullable();

            $table->string('google_plus_name')->nullable();
            $table->string('google_plus_link')->nullable();
            $table->string('aim_link')->nullable();
            $table->string('window_live_link')->nullable();
            $table->string('yahoo_link')->nullable();
            $table->string('icq_link')->nullable();
            $table->string('skype_link')->nullable();
            $table->string('google_talk_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}

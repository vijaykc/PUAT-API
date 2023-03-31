<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Members extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('membership_level_id');
            $table->string('email');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('mm_user_id')->nullable();
            $table->enum('is_active', ['no', 'yes'])->default('yes');
            $table->string('referer_url')->nullable();
            $table->string('thirdrdparty_user_id')->nullable();
            $table->string('confirmation_url')->nullable();
            $table->string('tokenized_login_url')->nullable();
            $table->timestamps();
        });

        Schema::table('members', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

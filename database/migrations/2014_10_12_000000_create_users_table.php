<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->bigIncrements('user_id'); 
            $table->string('user_name');
            $table->string('user_seo')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('gender')->default('Male'); 
            $table->string('email')->unique();
            $table->string('password'); 
            $table->Integer('country_id')->nullable();
            $table->string('region')->nullable();
            $table->text('about_me')->nullable();
            $table->Integer('date_added');
            $table->integer('status');
            $table->string('profile_image')->nullable();
            $table->string('activation_code')->nullable();
            $table->bigInteger('last_login_date');
            $table->bigInteger('active_counter')->default(0);
            $table->integer('is_top_member');
            $table->integer('last_review');
            $table->integer('last_comment');
            $table->string('fb_id')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->string('google_oauth_uid')->nullable();
            $table->string('link')->nullable(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('tbl_users');
    }
}

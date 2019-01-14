<?php

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
            $table->increments('id');

            // User information
            $table->string('name');
            $table->text('notes')->nullable();

            // User localization
            $table->string('timezone')->default('UTC');
            $table->string('language')->default('en-US');

            // User customization
            $table->boolean('option_decimal_time')->default(false);

            // User authentication
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
            $table->index(['deleted_at']);
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
    }
}

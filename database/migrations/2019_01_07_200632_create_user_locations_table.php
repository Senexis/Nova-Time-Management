<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name')->unique();
            $table->text('notes')->nullable();

            $table->string('address_from');
            $table->string('address_to');
            $table->double('distance', 6, 1);
            
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
        Schema::dropIfExists('user_locations');
    }
}

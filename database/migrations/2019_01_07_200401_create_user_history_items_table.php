<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHistoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_history_items', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->decimal('hourly_rate', 8, 2);
            $table->decimal('travel_rate', 8, 2);

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
        Schema::dropIfExists('user_history_items');
    }
}

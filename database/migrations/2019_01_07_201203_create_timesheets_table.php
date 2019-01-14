<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned()->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('user_locations');

            $table->text('notes')->nullable();
            
            $table->integer('time_worked')->default(0);
            
            $table->datetime('started_at');
            $table->datetime('paused_at')->nullable();

            $table->enum('type', ['manual', 'tracked'])->default('manual');
            $table->datetime('resumed_at')->nullable();
            $table->datetime('ended_at')->nullable();

            $table->datetime('locked_at')->nullable();

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
        Schema::dropIfExists('timesheets');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->foreignId("class_id")->constrained();
            $table->string('title');
            $table->string('instruction');
            $table->decimal('points', 12, 3);
            $table->dateTime('duedate');
            $table->string('status', 1);
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
        Schema::dropIfExists('class_activities');
    }
}

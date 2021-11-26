<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivityMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activity_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId("class_activity_id")->constrained();
            $table->string('folder');
            $table->string('filename');
            $table->string('filesize');
            $table->string('filetype');
            $table->text('thumbnail')->nullable();
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
        Schema::dropIfExists('class_activity_materials');
    }
}

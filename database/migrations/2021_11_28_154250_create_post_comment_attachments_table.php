<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comment_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("post_comment_id")->nullable()->constrained();
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
        Schema::dropIfExists('post_comment_attachments');
    }
}

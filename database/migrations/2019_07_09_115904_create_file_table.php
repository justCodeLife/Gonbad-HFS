<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('file_type');
            $table->text('file_description');
            $table->string('file_size');
            $table->string('file_image');
            $table->string('file_url');
            $table->string('uploader_name');
            $table->unsignedInteger('category_id')->nullable();
            $table->tinyInteger('visibility')->default(0);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
        DB::statement('ALTER TABLE files ADD FULLTEXT (file_name,file_type,file_description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}

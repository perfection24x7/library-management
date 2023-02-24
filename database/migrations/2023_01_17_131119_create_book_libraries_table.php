<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_libraries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id')->index('book_libraries_book_id');
            $table->foreign('book_id')->references('id')->on('books');
            $table->unsignedBigInteger('library_id')->index('book_libraries_library_id');
            $table->foreign('library_id')->references('id')->on('libraries');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_libraries');
    }
}

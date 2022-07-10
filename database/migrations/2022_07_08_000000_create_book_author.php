<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookAuthor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('author', function (Blueprint $table) {
            $table->id();
            $table->string('fio');
            $table->date('birth_date');
            $table->date('death_date')->nullable();
            //$table->timestamps();
        });

        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('publish_date');
            $table->string('annotation')->nullable();
            //$table->timestamps();
        });

        Schema::create('book_author', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('book')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('author')->onUpdate('cascade')->onDelete('restrict');
            $table->primary(['book_id', 'author_id']);
            //$table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('book');
        Schema::dropIfExists('author');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->longText('text')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedInteger('category_id');
            $table->string('image')->nullable();
            $table->enum('status', [
                \App\Models\Book::STATUS_IN_PROGRESS,
                \App\Models\Book::STATUS_FINISHED,
                \App\Models\Book::STATUS_CANCELLED
            ])->default(\App\Models\Book::STATUS_IN_PROGRESS);
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
        Schema::dropIfExists('books');
    }
}

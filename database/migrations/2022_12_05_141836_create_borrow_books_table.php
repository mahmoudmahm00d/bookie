<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('borrow_id');
            $table->float('price');
            $table->float('sale_price');
            $table->foreign('borrow_id')->references('id')->on('borrows')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
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
        Schema::table('borrow_books', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropForeign(['borrow_id']);
        });
        Schema::dropIfExists('borrow_books');
    }
};

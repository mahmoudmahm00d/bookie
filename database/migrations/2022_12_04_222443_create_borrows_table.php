<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->required();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->comment('[ PENDING, REJECTED, ACCEPTED, RETURNED ]')->default('PENDING');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->dateTime('deadline')->nullable();
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
        Schema::table('borrows', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropForeign(['genre_id']);
        });

        Schema::dropIfExists('borrows');
    }
}

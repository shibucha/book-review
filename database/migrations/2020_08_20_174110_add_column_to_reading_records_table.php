<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReadingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reading_records', function (Blueprint $table) {
            $table->string('book_id')->after('user_id')->nullable();
            $table->foreign('book_id')->references('google_book_id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reading_records', function (Blueprint $table) {
            $table->dropForeign('reading_records_book_id_foreign');
            $table->dropColumn('book_id');
        });
    }
}

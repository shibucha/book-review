<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('my_favorite_01', 50)->nullable()->comment('お気に入りの本1');
            $table->string('my_favorite_02', 50)->nullable()->comment('お気に入りの本2');
            $table->string('my_favorite_03', 50)->nullable()->comment('お気に入りの本3');
            $table->string('my_favorite_reason_01',255)->nullable()->comment('お気に入りの理由１');
            $table->string('my_favorite_reason_02',255)->nullable()->comment('お気に入りの理由２');
            $table->string('my_favorite_reason_03',255)->nullable()->comment('お気に入りの理由３');
            $table->bigInteger('my_favorite_isbn_01')->nullable()->comment('お気に入りの本ISBN_１');
            $table->bigInteger('my_favorite_isbn_02')->nullable()->comment('お気に入りの本ISBN_２');
            $table->bigInteger('my_favorite_isbn_03')->nullable()->comment('お気に入りの本ISBN_３');
            $table->timestamps();

             // 外部キー設定
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_favorites');
    }
}

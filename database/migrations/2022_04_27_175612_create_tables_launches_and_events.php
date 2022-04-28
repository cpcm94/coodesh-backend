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
        Schema::create('launches', function (Blueprint $table) {
            $table->string('id');
            $table->string('provider');
            $table->foreignId('article_id')->references('id')->on('articles')->onDelete('cascade');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->string('id');
            $table->string('provider');
            $table->foreignId('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
        });
        Schema::dropIfExists('events');

        Schema::table('launches', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
        });
        Schema::dropIfExists('launches');
    }
};

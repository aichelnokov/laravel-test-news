<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsRubricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_rubrics', function (Blueprint $table) {
            $table->bigInteger('news_id')->unsigned();
            $table->foreign('news_id')
                ->references('id')
                ->on('news')->onDelete('cascade');
            $table->bigInteger('rubrics_id')->unsigned();
            $table->foreign('rubrics_id')
                ->references('id')
                ->on('rubrics')->onDelete('cascade');
            $table->index(['news_id', 'rubrics_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_rubrics');
    }
}

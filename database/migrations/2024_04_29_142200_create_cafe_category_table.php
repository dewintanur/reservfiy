<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafeCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('cafe_category', function (Blueprint $table) {
            $table->unsignedBigInteger('cafe_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('cafe_id')->references('id')->on('cafes')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->primary(['cafe_id', 'category_id']); // Sets the primary key as a combination of cafe_id and category_id
        });
    }

    public function down()
    {
        Schema::dropIfExists('cafe_category');
    }
}

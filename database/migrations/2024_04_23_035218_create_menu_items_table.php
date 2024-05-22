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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cafe_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); // Misalnya, 99999.99 maksimum harga
            $table->timestamps();
        
            $table->foreign('cafe_id')->references('id')->on('cafes')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};

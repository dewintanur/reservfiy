<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafesTable extends Migration
{
    public function up()
    {
        Schema::create('cafes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');  // Pastikan baris ini ada
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cafes');
    }
}

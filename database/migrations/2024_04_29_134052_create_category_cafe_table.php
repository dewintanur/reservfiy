<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCafeTable extends Migration
{
    public function up()
    {
        Schema::create('category_cafe', function (Blueprint $table) {
            $table->foreignId('cafe_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['cafe_id', 'category_id']); // Composite key
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_cafe');
    }
}

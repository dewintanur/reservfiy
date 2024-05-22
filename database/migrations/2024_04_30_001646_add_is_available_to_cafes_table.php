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
    Schema::table('cafes', function (Blueprint $table) {
        $table->boolean('is_available')->default(true);  // Cafes are available by default
    });
}

public function down()
{
    Schema::table('cafes', function (Blueprint $table) {
        $table->dropColumn('is_available');
    });
}

};

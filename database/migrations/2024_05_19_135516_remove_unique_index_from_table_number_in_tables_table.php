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
    Schema::table('tables', function (Blueprint $table) {
        $table->dropUnique(['table_number']); // Menghapus indeks unik dari kolom table_number
    });
}

public function down()
{
    Schema::table('tables', function (Blueprint $table) {
        $table->unique('table_number'); // Menambahkan kembali indeks unik jika diperlukan
    });
}
};

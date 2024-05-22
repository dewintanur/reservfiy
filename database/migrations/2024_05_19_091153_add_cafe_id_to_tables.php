<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCafeIdToTables extends Migration
{
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->foreignId('cafe_id')->constrained()->onDelete('cascade')->after('id');
        });
    }

    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropForeign(['cafe_id']);
            $table->dropColumn('cafe_id');
        });
    }
}

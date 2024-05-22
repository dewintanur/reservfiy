<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyReservationsTableForUuid extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Tambahkan kolom baru untuk UUID
            $table->uuid('uuid')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Hapus kolom UUID jika diperlukan
            $table->dropColumn('uuid');
        });
    }
}

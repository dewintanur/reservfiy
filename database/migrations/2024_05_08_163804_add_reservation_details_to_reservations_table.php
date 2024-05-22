<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReservationDetailsToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->date('reservation_date')->after('user_id')->nullable();  // Menambahkan kolom tanggal reservasi
            $table->integer('table_number')->after('number_of_people')->nullable();  // Menambahkan kolom nomor meja
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('reservation_date');
            $table->dropColumn('table_number');
        });
    }
}

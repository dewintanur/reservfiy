<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('payment_status')->nullable(); // Menambahkan kolom payment_status
            $table->string('payment_method')->nullable(); // Menambahkan kolom payment_method
            $table->integer('applied_discount')->default(0); // Menambahkan kolom applied_discount
            $table->decimal('final_total', 15, 2)->default(0.00); // Menambahkan kolom final_total
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('payment_status'); // Menghapus kolom payment_status
            $table->dropColumn('payment_method'); // Menghapus kolom payment_method
            $table->dropColumn('applied_discount'); // Menghapus kolom applied_discount
            $table->dropColumn('final_total'); // Menghapus kolom final_total
        });
    }
}

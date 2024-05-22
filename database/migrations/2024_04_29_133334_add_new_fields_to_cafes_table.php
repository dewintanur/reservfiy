<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToCafesTable extends Migration
{
    public function up()
    {
        Schema::table('cafes', function (Blueprint $table) {
            $table->text('operational_hours')->nullable();
            $table->text('maps_link')->nullable();
            $table->text('photo')->nullable();
            $table->text('menu')->nullable();
            $table->float('rating', 3, 1)->nullable(); // e.g., 4.5
            $table->text('social_media')->nullable(); // JSON or string, depending on your needs
        });
    }

    public function down()
    {
        Schema::table('cafes', function (Blueprint $table) {
            $table->dropColumn([
                'operational_hours', 
                'maps_link', 
                'photo', 
                'menu', 
                'rating', 
                'social_media'
            ]);
        });
    }
}

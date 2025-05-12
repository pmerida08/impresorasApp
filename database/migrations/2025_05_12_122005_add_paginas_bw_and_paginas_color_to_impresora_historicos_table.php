<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('impresora_historicos', function (Blueprint $table) {
            $table->integer('paginas_bw')->nullable()->after('paginas');
            $table->integer('paginas_color')->nullable()->after('paginas_bw');
        });
    }

    public function down()
    {
        Schema::table('impresora_historicos', function (Blueprint $table) {
            $table->dropColumn('paginas_bw');
            $table->dropColumn('paginas_color');
        });
    }
};
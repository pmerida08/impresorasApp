<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('observaciones', 'descripcion');
        });
    }

    public function down()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('descripcion', 'observaciones');
        });
    }
};

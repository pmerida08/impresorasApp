<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('copias_semana', 'copias_mes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('copias_mes', 'copias_semana');
        });
    }
};

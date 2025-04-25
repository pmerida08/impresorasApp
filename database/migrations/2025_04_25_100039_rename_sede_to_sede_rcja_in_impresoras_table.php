<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('sede', 'sede_rcja');
        });
    }

    public function down()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('sede_rcja', 'sede');
        });
    }
};

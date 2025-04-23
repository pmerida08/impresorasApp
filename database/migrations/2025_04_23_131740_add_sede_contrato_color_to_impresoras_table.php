<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->string('sede');
            $table->string('num_contrato');
            $table->boolean('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->dropColumn(['sede', 'num_contrato', 'color']);
        });
    }
};

public function up(): void
{
    Schema::table('impresora_datos_snmp', function (Blueprint $table) {
        $table->string('fuser_status')->nullable()->default(null);
    });
}

public function down(): void
{
    Schema::table('impresora_datos_snmp', function (Blueprint $table) {
        $table->dropColumn('fuser_status');
    });
}

<?php
$host = "192.168.1.100"; // Dirección IP de la impresora
$community = "public"; // Comunidad SNMP (por defecto suele ser "public")

// OID específico para contar páginas en impresoras Lexmark
$oid = ".1.3.6.1.2.1.43.10.2.1.4.1.1"; 

// Consultar SNMP
$pagesPrinted = snmpget($host, $community, $oid);

if ($pagesPrinted === false) {
    echo "No se pudo obtener el contador de páginas.";
} else {
    // Limpiar el resultado
    $pagesPrinted = preg_replace('/[^0-9]/', '', $pagesPrinted);
    echo "Total de páginas impresas: $pagesPrinted";
}
?>
<?php
if (function_exists('snmpget')) {
    echo "SNMP está habilitado.";
} else {
    echo "SNMP NO está habilitado.";
}
?>


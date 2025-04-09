<?php
$host = "10.66.129.46";
$community = "public"; // Comunidad SNMP (por defecto suele ser "public")

$oid = ".1.3.6.1.2.1.2.2.1.6.1";

// Consultar SNMP
$model = snmpget($host, $community, $oid);
echo $model;
?>


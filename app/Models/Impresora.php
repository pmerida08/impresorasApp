<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Impresora
 *
 * @property $id
 * @property $tipo
 * @property $ubicacion
 * @property $usuario
 * @property $ip
 * @property $mac
 * @property $nombre_reserva_dhcp
 * @property $observaciones
 * @property $nombre_cola_hacos
 * @property $num_serie
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Impresora extends Model
{
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo',
        'ubicacion',
        'usuario',
        'ip',
        'nombre_reserva_dhcp',
        'observaciones',
        'nombre_cola_hacos',
    ];

    public function historicos()
    {
        return $this->hasMany(ImpresoraHistorico::class);
    }

    public function getModeloAttribute()
    {
        $host = $this->attributes['ip'];

        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

        $oid = ".1.3.6.1.2.1.25.3.2.1.3.1";

        // Consultar SNMP
        $model = snmpget($host, $community, $oid);
        
        return substr(explode(":", $model)[1], 2, -1);
    }
    public function getPaginasTotalAttribute()
    {
        $host = $this->attributes['ip'];

        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

        $oid = ".1.3.6.1.2.1.43.10.2.1.4.1.1";

        // Consultar SNMP
        $model = snmpget($host, $community, $oid);
        return explode(":", $model)[1];
    }

    public function getNumSerieAttribute()
    {
        $host = $this->attributes['ip'];

        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

        $oid = ".1.3.6.1.2.1.43.5.1.1.17.1";

        // Consultar SNMP
        $model = snmpget($host, $community, $oid);
        return substr(explode(":", $model)[1], 2, -1);
    }
    public function getMacAttribute()
    {
        $host = $this->attributes['ip'];

        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

        $oid = ".1.3.6.1.2.1.2.2.1.6.1";

        // Consultar SNMP
        $result = snmpget($host, $community, $oid);
        return explode(":",$result)[1];
    }

    // public function getTonerAttribute(){
    //     $host = $this->attributes['ip'];

    //     $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

    //     $oid = ".1.3.6.1.2.1.43.11.1.1.6.1.1";

    //     // Consultar SNMP
    //     $toner = snmpget($host, $community, $oid);
    //     return explode(":", $toner)[1];
    // }

    // public function getUnidadImgAttribute(){
    //     $host = $this->attributes['ip'];

    //     $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

    //     $oid = ".1.3.6.1.2.1.43.11.1.1.6.1.2";

    //     // Consultar SNMP
    //     $unidadImg = snmpget($host, $community, $oid);
    //     return explode(":", $unidadImg)[1];
    // }
    // public function getPaginasRestantesTonerAttribute(){
    //     $host = $this->attributes['ip'];

    //     $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

    //     $oid = ".1.3.6.1.2.1.43.11.1.1.9.1.1";

    //     $pagRest = snmpget($host, $community, $oid);
    //     return explode(":", $pagRest)[1];
    // }

    // public function getPaginasRestantesUnidadImgAttribute(){
    //     $host = $this->attributes['ip'];

    //     $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

    //     $oid = ".1.3.6.1.2.1.43.11.1.1.9.1.2";

    //     $pagRest = snmpget($host, $community, $oid);
    //     return explode(":", $pagRest)[1];
    // }

    // public function getAlertAttribute(){
    //     $host = $this->attributes['ip'];

    //     $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

    //     $oid = ".1.3.6.1.2.1.43.18.1.1.8";

    //     $alert = snmpget($host, $community, $oid);
    //     return explode(":", $alert)[1];
    // }

    // public function getNumSerieAttribute(){
    //     $host = $this->attributes['ip'];

    //     $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

    //     $oid = ".1.3.6.1.2.1.43.5.1.1.17";

    //     $numSerie = snmpget($host, $community, $oid);
    //     return explode(":", $numSerie)[1];
    // }
}

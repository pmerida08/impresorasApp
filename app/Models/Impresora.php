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
 * @property $nombre_reserva_dhcp
 * @property $descripcion
 * @property $organismo
 * @property $nombre_cola_hacos
 * @property $sede_rcja
 * @property $contrato
 * @property $num_serie
 * @property $color
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
        'descripcion',
        'organismo',
        'nombre_cola_hacos',
        'sede_rcja',
        'contrato',
        'num_serie',
        'color'
    ];

    public function historicos()
    {
        return $this->hasMany(ImpresoraHistorico::class);
    }

    public function datosSnmp()
    {
        return $this->hasOne(ImpresoraDatosSnmp::class);
    }


    public function getModeloAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public";
        $oid = ".1.3.6.1.2.1.25.3.2.1.3.1";

        try {

            $model = @\snmpget($host, $community, $oid);

            if ($model === false) {
                return "No responde";
            }

            return substr(explode(":", $model)[1], 2, -1);
        } catch (\Exception $e) {
            return "Error SNMP";
        }
    }

    public function getPaginasTotalAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public";
        $oid = ".1.3.6.1.2.1.43.10.2.1.4.1.1";

        try {

            $model = @\snmpget($host, $community, $oid);

            if ($model === false) {
                return 0;
            }

            return explode(":", $model)[1];
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getPaginasBWAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public";
        $oids = [
            ".1.3.6.1.4.1.11.2.3.9.4.2.1.4.1.2.6.0",
            ".1.3.6.1.4.1.1248.1.2.2.27.1.1.3.1.1"
        ];

        try {

            foreach ($oids as $oid) {
                $model = @\snmpget($host, $community, $oid);
                if ($model !== false) {
                    return intval(explode(":", $model)[1]);
                }
            }
            return "No responde";
        } catch (\Exception $e) {
            return "Error SNMP";
        }
    }

    public function getPaginasColorAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public";
        $oids = [
            ".1.3.6.1.4.1.11.2.3.9.4.2.1.4.1.2.7.0",
            ".1.3.6.1.4.1.1248.1.2.2.6.1.1.5.1.2", // HP PAGEWIDE COLOR        
            ".1.3.6.1.2.1.43.10.2.1.5.1.1",
        ];

        try {

            foreach ($oids as $oid) {
                $model = @\snmpget($host, $community, $oid);
                if ($model !== false) {
                    return intval(explode(":", $model)[1]);
                }
            }
            return "No responde";
        } catch (\Exception $e) {
            return "Error SNMP";
        }
    }

    public function getMacAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public";

        $oids = [
            ".1.3.6.1.2.1.2.2.1.6.1",
            ".1.3.6.1.2.1.2.2.1.6.2",
            ".1.3.6.1.2.1.2.2.1.6.3",
        ];

        try {

            foreach ($oids as $oid) {
                $snmpResult = @\snmpget($host, $community, $oid);

                if (!$snmpResult) {
                    continue;
                }

                $parts = explode(":", $snmpResult, 2);
                if (count($parts) < 2) {
                    continue;
                }

                $rawMac = trim($parts[1]);
                $macParts = array_filter(array_map('trim', explode(' ', $rawMac)));
                $formattedMac = strtoupper(implode(':', $macParts));
                if (!empty($formattedMac)) {
                    return $formattedMac;
                }
            }

            return "No responde";
        } catch (\Exception $e) {
            return "Error SNMP";
        }
    }

    public function actualizarNumSerie()
    {
        $host = $this->attributes['ip'];
        $community = "public";
        $oid = ".1.3.6.1.2.1.43.5.1.1.17.1";

        try {

            $model = @\snmpget($host, $community, $oid);

            if ($model === false) {
                $this->num_serie = "No responde";
            } else {
                $this->num_serie = substr(explode(":", $model)[1], 2, -1);
            }
        } catch (\Exception $e) {
            $this->num_serie = "Error SNMP";
        }

        $this->save();
    }
}

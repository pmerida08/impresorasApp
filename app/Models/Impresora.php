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
 * @property $observaciones
 * @property $nombre_cola_hacos
 * @property $sede
 * @property $num_contrato
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
        'observaciones',
        'nombre_cola_hacos',
        'sede_rcja',
        'num_contrato',
        'color'
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

        try {
            // Consultar SNMP
            $model = @snmpget($host, $community, $oid);

            // Verificar si no hay respuesta o la respuesta es inválida
            if ($model === false) {
                return "No responde"; // Retorna un mensaje si no hay respuesta
            }

            return substr(explode(":", $model)[1], 2, -1); // Retorna el modelo de la impresora
        } catch (\Exception $e) {
            return "Error SNMP"; // En caso de excepciones, retorna un mensaje de error
        }
    }

    public function getPaginasTotalAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")
        $oid = ".1.3.6.1.2.1.43.10.2.1.4.1.1";

        try {
            // Consultar SNMP
            $model = @snmpget($host, $community, $oid);

            // Verificar si no hay respuesta o la respuesta es inválida
            if ($model === false) {
                return 0; // Retorna 0 si no hay respuesta
            }

            return explode(":", $model)[1]; // Retorna el número total de páginas
        } catch (\Exception $e) {
            return 0; // Retorna 0 en caso de error de SNMP
        }
    }
    public function getPaginasBWAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public";
        $oids = [
            ".1.3.6.1.4.1.11.2.3.9.4.2.1.4.1.2.6.0",
            ".1.3.6.1.2.1.43.10.2.1.4.1.1"
        ];

        try {
            foreach ($oids as $oid) {
                $model = @snmpget($host, $community, $oid);
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
            ".1.3.6.1.2.1.43.10.2.1.5.1.1"
        ];

        try {
            foreach ($oids as $oid) {
                $model = @snmpget($host, $community, $oid);
                if ($model !== false) {
                    return intval(explode(":", $model)[1]);
                }
            }
            return "No responde";
        } catch (\Exception $e) {
            return "Error SNMP";
        }
    }



    public function getNumSerieAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")
        $oid = ".1.3.6.1.2.1.43.5.1.1.17.1";

        try {
            // Consultar SNMP
            $model = @snmpget($host, $community, $oid);

            // Verificar si no hay respuesta o la respuesta es inválida
            if ($model === false) {
                return "No responde"; // Retorna un mensaje si no hay respuesta
            }

            return substr(explode(":", $model)[1], 2, -1); // Retorna el número de serie
        } catch (\Exception $e) {
            return "Error SNMP"; // Retorna un mensaje en caso de error
        }
    }
    public function getMacAttribute()
    {
        $host = $this->attributes['ip'];
        $community = "public"; // Comunidad SNMP (por defecto suele ser "public")

        // Lista de posibles interfaces para consultar la MAC
        $oids = [
            ".1.3.6.1.2.1.2.2.1.6.1",
            ".1.3.6.1.2.1.2.2.1.6.2",
            ".1.3.6.1.2.1.2.2.1.6.3",
        ];

        try {
            foreach ($oids as $oid) {
                $snmpResult = @snmpget($host, $community, $oid);

                // Verificar si no hay respuesta de SNMP
                if (!$snmpResult) {
                    continue; // Intenta con el siguiente OID
                }

                // Extraer la parte con la MAC address (después de "STRING:")
                $parts = explode(":", $snmpResult, 2);
                if (count($parts) < 2) {
                    continue; // Formato inesperado
                }

                // Limpiar y formatear la MAC address
                $rawMac = trim($parts[1]);
                $macParts = array_filter(array_map('trim', explode(' ', $rawMac)));
                $formattedMac = strtoupper(implode(':', $macParts));
                if (!empty($formattedMac)) {
                    return $formattedMac;
                }
            }

            return "No responde"; // Si no se encuentra una MAC válida
        } catch (\Exception $e) {
            return "Error SNMP"; // En caso de excepción, retornar un mensaje de error
        }
    }

}

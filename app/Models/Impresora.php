<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ImpresoraDatosSnmp;

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

    public function datosSnmp()
    {
        return $this->hasOne(ImpresoraDatosSnmp::class, 'impresora_id', 'id');
    }


    // Accesores desde datos SNMP
    public function getModeloAttribute()
    {
        return $this->datosSnmp?->modelo ?? 'Desconocido';
    }

    public function getMacAttribute()
    {
        return $this->datosSnmp?->mac ?? 'No registrado';
    }

    public function getPaginasTotalAttribute()
    {
        return $this->datosSnmp?->paginas_total ?? 0;
    }

    public function getPaginasBWAttribute()
    {
        return $this->datosSnmp?->paginas_bw ?? 0;
    }

    public function getPaginasColorAttribute()
    {
        return $this->datosSnmp?->paginas_color ?? 0;
    }

    public function getNumSerieSnmpAttribute()
    {
        return $this->datosSnmp?->num_serie ?? 'No registrado';
    }
}

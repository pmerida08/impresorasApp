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
 * @property $activo
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
        'color',
        'activo'
    ];

    public function datosSnmp()
    {
        return $this->hasOne(ImpresoraDatosSnmp::class, 'impresora_id', 'id');
    }

    /**
     * Relación con el modelo ImpresoraHistorico
     */
    public function historico()
    {
        return $this->hasMany(ImpresoraHistorico::class, 'impresora_id', 'id');
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

    public function getNumSerieAttribute()
    {
        return $this->datosSnmp?->num_serie ?? 'No registrado';
    }

    public function getBlackTonerAttribute()
    {
        return $this->datosSnmp?->black_toner ?? 'No registrado';
    }

    public function getCyanTonerAttribute()
    {
        return $this->datosSnmp?->cyan_toner ?? 'No registrado';
    }

    public function getMagentaTonerAttribute()
    {
        return $this->datosSnmp?->magenta_toner ?? 'No registrado';
    }

    public function getYellowTonerAttribute()
    {
        return $this->datosSnmp?->yellow_toner ?? 'No registrado';
    }

    public function getMaxCapacityAttribute()
    {
        $toners = $this->datosSnmp;
        return $toners?->black_toner / $toners?->max_capacity * 100 ?? 'No registrado';
    }

    public function showAlert($toner)
    {
        if ($toner < 5) {
            return '🪫 CRÍTICO';
        } elseif ($toner < 20) {
            return '⚠️ ADVERTENCIA';
        } else {
            return '✅ BUEN ESTADO';
        }
    }

    protected $appends = ['num_serie']; // Para acceder por JSON para la búsqueda

}

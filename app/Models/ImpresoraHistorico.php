<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpresoraHistorico extends Model
{
    protected $fillable = ['impresora_id', 'fecha', 'paginas'];

    // Relación con el modelo Impresora
    public function impresora()
    {
        return $this->belongsTo(Impresora::class, 'impresora_id', 'id');
    }

    // Obtener las páginas por mes
    public function getPaginasPorMes()
    {
        return $this->where('impresora_id', $this->impresora_id)
            ->selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, MAX(paginas) - MIN(paginas) as paginas_mes')
            ->groupByRaw('YEAR(fecha), MONTH(fecha)')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();
    }
}

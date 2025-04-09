<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpresoraHistorico extends Model
{
    protected $fillable = ['impresora_id', 'fecha', 'paginas'];

    public function impresora()
    {
        return $this->belongsTo(Impresora::class);
    }

    public function getPaginasPorMes()
    {
        return $this->historicos()
            ->selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, MAX(paginas) - MIN(paginas) as paginas_mes')
            ->groupByRaw('YEAR(fecha), MONTH(fecha)')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpresoraHistorico extends Model
{
    use HasFactory;

    protected $table = 'impresora_historicos';
    protected $fillable = [
        'impresora_id',
        'fecha',
        'paginas',
        'paginas_bw',
        'paginas_color',
    ];

    // Relación con el modelo Impresora
    public function impresora()
    {
        return $this->belongsTo(Impresora::class, 'impresora_id', 'id');
    }

    // Obtener las páginas por mes
    public function getPaginasPorMes()
    {
        return $this->where('impresora_id', $this->impresora_id)
            ->selectRaw('
                YEAR(fecha) as anio, 
                MONTH(fecha) as mes, 
                MAX(paginas) - MIN(paginas) as paginas_mes,
                MAX(paginas_bw) - MIN(paginas_bw) as paginas_bw_mes,
                MAX(paginas_color) - MIN(paginas_color) as paginas_color_mes
            ')
            ->groupByRaw('YEAR(fecha), MONTH(fecha)')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();
    }
}

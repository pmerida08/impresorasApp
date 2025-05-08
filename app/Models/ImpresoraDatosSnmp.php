<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpresoraDatosSnmp extends Model
{
    protected $table = 'impresora_datos_snmp';

    protected $fillable = [
        'impresora_id',
        'mac',
        'paginas_total',
        'paginas_bw',
        'paginas_color',
        'num_serie',
        'modelo',
        'black_toner',
        'cyan_toner',
        'magenta_toner',
        'yellow_toner',
        'max_capacity'
    ];

    public function impresora()
    {
        return $this->belongsTo(Impresora::class);
    }
}
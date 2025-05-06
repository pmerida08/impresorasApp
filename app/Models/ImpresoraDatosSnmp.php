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
    ];

    public function impresora()
    {
        return $this->belongsTo(Impresora::class);
    }
}
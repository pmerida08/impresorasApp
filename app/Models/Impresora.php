<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Impresora
 *
 * @property $id
 * @property $modelo
 * @property $copias_dia
 * @property $copias_mes
 * @property $copias_anio
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
    protected $fillable = ['modelo', 'copias_dia', 'copias_mes', 'copias_anio'];


}

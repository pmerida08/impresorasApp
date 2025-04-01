<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Impresora
 *
 * @property $id
 * @property $modelo
 * @property $fotocopias
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
    protected $fillable = ['modelo', 'fotocopias'];


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAtraccion extends Model
{
    protected $table = 'tipo_atraccions';
    protected $primaryKey = 'id_tipo';
    public $timestamps = true;

    protected $fillable = ['nombre_tipo'];

    // ✔ Relación correcta
    public function lugares()
    {
        return $this->hasMany(LugarTuristico::class, 'id_tipo', 'id_tipo');
    }
}

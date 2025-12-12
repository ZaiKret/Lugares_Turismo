<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LugarTuristico extends Model
{
    protected $table = 'lugar_turisticos'; 
    protected $primaryKey = 'id_lugar';
    public $timestamps = true;

    protected $fillable = [
        'nombre_lugar',
        'id_provincia',
        'id_tipo',
        'latitud',
        'longitud',
        'descripcion',
        'anio_creacion',
        'accesibilidad'
    ];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'id_provincia', 'id_provincia');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAtraccion::class, 'id_tipo', 'id_tipo');
    }
}

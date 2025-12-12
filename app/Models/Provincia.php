<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincia'; 
    protected $primaryKey = 'id_provincia';
    public $timestamps = false;

    protected $fillable = ['nombre_provincia'];

    
    public function lugares()
    {
        return $this->hasMany(\App\Models\LugarTuristico::class, 'id_provincia', 'id_provincia');
    }
}

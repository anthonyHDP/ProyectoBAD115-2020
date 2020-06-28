<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';
    protected $primaryKey = 'codigo_puesto';
    protected $fillable = ['descripcion'];

    
    public function Contratos()
    {
        return $this->hasMany('App\Contratos');
    }
    public function Horarios_Laborales()
    {
        return $this->hasMany('App\Horarios_laborales');
    }
    public function Empleados()
    {
        return $this->belongsTo('App\Empleados');
    }
}
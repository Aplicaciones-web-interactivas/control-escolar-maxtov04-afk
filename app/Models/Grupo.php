<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'horario_id'
    ];

    public function horario() {
        return $this->belongsTo(Horario::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
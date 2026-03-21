<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'usuario_id',
        'calificacion'
    ];

    public function grupo() {
        return $this->belongsTo(Grupo::class);
    }

    public function alumno() {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
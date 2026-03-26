<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificacions';

    protected $fillable = ['grupo_id', 'usuario_id', 'calificacion'];

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function grupo() {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
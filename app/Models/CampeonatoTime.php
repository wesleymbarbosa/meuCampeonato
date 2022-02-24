<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampeonatoTime extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'campeonatotimes';
    protected $fillable = ['id_campeonato', 'id_time', 'pontuacao', 'dt_cadastro'];

    public function campeonato()
    {
        return $this->belongsTo(Campeonato::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function checkQuantidade($id_campeonato)
    {
        return $this->where('id_campeonato', $id_campeonato)->count();
    }

    public function checkTime($id_campeonato, $id_time)
    {
        return $this->where('id_campeonato', $id_campeonato)
               ->where('id_time', $id_time)->exists();
    }
}

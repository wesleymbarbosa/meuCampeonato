<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampeonatoJogo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'campeonatojogos';
    protected $fillable = ['id_campeonato', 'id_time_casa', 'id_time_fora', 'placar_time_casa', 'placar_time_fora', 'fase', 'dt_cadastro'];

    public function campeonato()
    {
        return $this->belongsTo(Campeonato::class);
    }

    public function time_casa()
    {
        return $this->belongsTo(Time::class);
    }

    public function time_fora()
    {
        return $this->belongsTo(Time::class);
    }
}

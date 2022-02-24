<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampeonatoJogo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'campeonatojogos';
    protected $fillable = ['id_campeonato', 'id_time', 'pontuacao', 'dt_cadastro'];

    public function campeonato()
    {
        return $this->belongsTo(Campeonato::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

}

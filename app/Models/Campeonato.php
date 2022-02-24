<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiTrait;

class Campeonato extends Model
{
    use HasFactory, ApiTrait;
    public $timestamps = false;
    protected $allowFilter = ['id', 'nome', 'status', 'dt_cadastro'];
    protected $allowSort = ['id', 'nome', 'status', 'dt_cadastro'];
    protected $fillable = ['nome', 'status', 'dt_cadastro'];

    public function times()
    {
        return $this->hasMany(CampeonatoTime::class, 'id_campeonato', 'id');
    }

    public function jogos()
    {
        return $this->hasMany(CampeonatoJogo::class, 'id_campeonato', 'id');
    }
}

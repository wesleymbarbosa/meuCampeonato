<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiTrait;

class Time extends Model
{
    use HasFactory, ApiTrait;
    public $timestamps = false;
    protected $allowFilter = ['id', 'nome', 'sigla', 'dt_cadastro'];
    protected $allowSort = ['id', 'nome', 'sigla', 'dt_cadastro'];
    protected $fillable = ['nome', 'sigla', 'dt_cadastro'];

    public function campeonatos()
    {
        return $this->hasMany(CampeonatoTime::class, 'id_time', 'id');
    }
}

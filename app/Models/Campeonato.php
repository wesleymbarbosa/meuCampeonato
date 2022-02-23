<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiTrait;

class Campeonato extends Model
{
    use HasFactory, ApiTrait;
    public $timestamps = false;
    protected $allowFilter = ['id', 'nome', 'dt_cadastro'];
    protected $allowSort = ['id', 'nome', 'dt_cadastro'];
    protected $fillable = ['nome', 'dt_cadastro'];
}

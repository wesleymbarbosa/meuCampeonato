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
    
    public function sortTimes($request)
    {
        $id_campeonato = $request['id_campeonato'];
        $arr_times = $request['arr_times'];

        $query = $this->select('id_time')->distinct()
                ->where('id_campeonato', $id_campeonato);

        if(count($arr_times) > 0){
            $query->whereIn('id_time', $arr_times);
        }
        
        return $query->inRandomOrder()->get();
    }

    public function getClassificacao($request)
    {
        $id_campeonato = $request['id_campeonato'];
        $arr_times = isset($request['arr_times']) ? $request['arr_times'] : [];

        $query = $this->join('times', 'id_time', '=', 'times.id')
                ->where('id_campeonato', $id_campeonato);

        if(count($arr_times) > 0){
            $query->whereIn('id_time', $arr_times);
        }
        
        return $query->orderBy('pontuacao', 'DESC')
            ->orderBy('campeonatotimes.dt_cadastro', 'ASC')
            ->get(['id_time', 'nome', 'sigla', 'pontuacao', 'campeonatotimes.dt_cadastro']);
    }
}

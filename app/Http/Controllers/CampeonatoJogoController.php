<?php

namespace App\Http\Controllers;

use App\Models\CampeonatoJogo;
use App\Models\Campeonato;
use App\Models\Time;
use App\Http\Resources\CampeonatoJogoResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class CampeonatoJogoController extends Controller
{
    private $validator;
    private $qtd_times;
    private $campeonato;
    private $time;

    public function __construct(CampeonatoJogo $campeonatoJogo)
    {
        $this->campeonatoJogo = $campeonatoJogo;
        $this->validator = Validator::class;
        $this->campeonato = new Campeonato();
        $this->time = new Time();
        $this->qtd_times = 8;
    }

    public function store(Request $request)
    {
        $validator = $this->validator::make($request->all(),[
            'id_campeonato' => 'required|exists:campeonatos,id',
            'id_time_casa' => 'required|exists:times,id',
            'id_time_fora' => 'required|exists:times,id',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $campeonatoJogo = $this->campeonatoJogo->create($request->all());

        return $this->show($campeonatoJogo->id);
    }

    public function show($id)
    {
        if ($campeonatoJogo = $this->campeonatoJogo->find($id)) {
            $campeonatoJogo->campeonato = $this->campeonato->find($campeonatoJogo->id_campeonato);
            $campeonatoJogo->time_casa = $this->time->find($campeonatoJogo->id_time_casa);
            $campeonatoJogo->time_fora = $this->time->find($campeonatoJogo->id_time_fora);

            return CampeonatoJogoResource::make($campeonatoJogo);
        }
        
        return response()->json('Registro não encontrado', 404);
    }

    public function destroy(CampeonatoJogo $campeonatoJogo)
    {
        if($campeonatoJogo->delete()){
            return response()->json('Registro excluído com sucesso', 200);
        } else {
            return response()->json('Registro não encontrado', 404); 
        }
    }
}

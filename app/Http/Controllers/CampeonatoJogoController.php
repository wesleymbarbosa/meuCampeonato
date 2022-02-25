<?php

namespace App\Http\Controllers;

use App\Models\CampeonatoJogo;
use App\Models\Campeonato;
use App\Models\Time;
use App\Http\Resources\CampeonatoJogoResource;
use App\Http\Controllers\Controller;
use App\Services\CampeonatoService;
use Illuminate\Http\Request;
use Validator;


class CampeonatoJogoController extends Controller
{
    private $validator;    
    private $campeonato;
    private $time;
    private CampeonatoService $campeonatoService;

    public function __construct(CampeonatoJogo $campeonatoJogo)
    {
        $this->campeonatoJogo = $campeonatoJogo;
        $this->validator = Validator::class;
        $this->campeonato = new Campeonato();
        $this->time = new Time();
        $this->campeonatoService = new CampeonatoService();
    }

    public function show($id)
    {
        if ($campeonatoJogo = $this->campeonatoJogo->where('id_campeonato', $id)->get()) {
            return CampeonatoJogoResource::collection($campeonatoJogo);
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

    public function sorteio($id)
    {
        $campeonato = $this->campeonato->find($id);
        if(!isset($campeonato->id)){
            return response()->json('Registro não encontrado', 404); 
        }
        
        $request['id_campeonato'] = $id;
        $sorteio = $this->campeonatoService->sortJogos($request);
        $retorno = [
            'id_campeonato' => $campeonato->id,
            'nome_campeonato' => $campeonato->nome,
        ];

        foreach ($sorteio as $key => $id_time) {
            $time = $this->time->find($id_time);
            $retorno['finalistas'][$key] = $time->nome;
        }

        $retorno['jogos'] = $this->show($request['id_campeonato']);

        return response()->json($retorno, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CampeonatoTime;
use App\Models\Time;
use App\Http\Resources\CampeonatoTimeResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class CampeonatoTimeController extends Controller
{
    private $validator;
    private $qtd_times;
    private $time;

    public function __construct(CampeonatoTime $campeonatoTime)
    {
        $this->campeonatoTime = $campeonatoTime;
        $this->validator = Validator::class;
        $this->time = new Time();
        $this->qtd_times = 8;
    }

    public function store(Request $request)
    {
        $validator = $this->validator::make($request->all(),[
            'id_campeonato' => 'required|exists:campeonatos,id',
            'id_time' => 'required|exists:times,id',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        if($this->campeonatoTime->checkQuantidade($request->id_campeonato) >= $this->qtd_times){
            return response()->json('Quantidade de times excedida, o máximo é '.$this->qtd_times, 400);
        }

        if($this->campeonatoTime->checkTime($request->id_campeonato, $request->id_time)){
            return response()->json('Time já cadastrado no campeonato', 400);
        }

        $campeonatoTime = $this->campeonatoTime->create($request->all());

        return $this->show($campeonatoTime->id);
    }

    public function show($id)
    {
        if ($campeonatoTime = $this->campeonatoTime->find($id)) {
            $campeonatoTime->time = $this->time->find($campeonatoTime->id_time);

            return CampeonatoTimeResource::make($campeonatoTime);
        }
        
        return response()->json('Registro não encontrado', 404);
    }

    public function destroy(CampeonatoTime $campeonatoTime)
    {
        if($campeonatoTime->delete()){
            return response()->json('Registro excluído com sucesso', 200);
        } else {
            return response()->json('Registro não encontrado', 404); 
        }
    }

    public function getClassificacao($id)
    {
        $request['id_campeonato'] = $id;
        $classificacao = $this->campeonatoTime->getClassificacao($request);
        $retorno = ['id_campeonato' => $id, 'data' => []];
        for($i = 0; $i < count($classificacao); $i++){
            $classificacao[$i]['posicao'] = $i+1;
            $retorno['data'][] = $classificacao[$i];
        }

        return response()->json($retorno, 200);
    }
}

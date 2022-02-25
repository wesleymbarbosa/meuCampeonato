<?php

namespace App\Services;

use App\Models\Time;
use App\Models\Campeonato;
use App\Models\CampeonatoTime;
use App\Models\CampeonatoJogo;

class CampeonatoService
{
    private Time $time;
    private Campeonato $campeonato;
    private CampeonatoTime $campeonatoTime;
    private CampeonatoJogo $campeonatoJogo;
    private $qtd_times;

    public function __construct()
    {
        $this->time = new Time();
        $this->campeonato = new Campeonato();
        $this->campeonatoTime = new CampeonatoTime();
        $this->campeonatoJogo = new CampeonatoJogo();
        $this->qtd_times = [
            'maximo'  => 8,
            'quartas' => 8,
            'semi' => 4,
            'final' => 2,
        ];
    }

    private function getPlacar()
    {
        // TODO: Fazer em python
        return [
            'casa' => rand(0, 8),
            'fora' => rand(0, 8),
        ];
    }

    private function getResultado($jogo)
    {
        $vencedor = null;
        if($jogo['placar_time_casa'] == $jogo['placar_time_fora']){
            $request = [
                'id_campeonato' => $jogo['id_campeonato'],
                'arr_times' => [$jogo['id_time_casa'], $jogo['id_time_fora']],
            ];
            $classificacao = $this->campeonatoTime->getClassificacao($request);
            $vencedor = $classificacao[0]->id_time;
        } else if($jogo['placar_time_casa'] > $jogo['placar_time_fora']){
            $vencedor = $jogo['id_time_casa'];
        } else if($jogo['placar_time_casa'] < $jogo['placar_time_fora']){
            $vencedor = $jogo['id_time_fora'];
        }

        $perdedor = ($vencedor == $jogo['id_time_casa'] ? $jogo['placar_time_fora'] : $jogo['id_time_casa']);

        //Atualiza pontuação dos times
        $this->attPontuacao($jogo);

        return ['vencedor' => $vencedor, 'perdedor' => $perdedor];
    }

    private function attPontuacao($jogo)
    {
        $arr_casa = ['id_campeonato'=>$jogo['id_campeonato'], 'id_time'=>$jogo['id_time_casa']];
        if($timeCasa = $this->campeonatoTime->where($arr_casa)->first()){
            $pointCasa = $timeCasa->pontuacao + ($jogo['placar_time_casa'] - $jogo['placar_time_fora']);
            $this->campeonatoTime->where($arr_casa)->update(['pontuacao'=>$pointCasa]);
        }
        
        $arr_fora = ['id_campeonato'=>$jogo['id_campeonato'], 'id_time'=>$jogo['id_time_fora']];
        if($timefora = $this->campeonatoTime->where($arr_fora)->first()){
            $pointfora = $timefora->pontuacao + ($jogo['placar_time_fora'] - $jogo['placar_time_casa']);
            $this->campeonatoTime->where($arr_fora)->update(['pontuacao'=>$pointfora]);
        }
    }

    public function sortJogos($request)
    {
        if($this->campeonatoTime->checkQuantidade($request['id_campeonato']) != $this->qtd_times['maximo']){
            return response()->json('A quantidade de times participantes deve ser '.$this->qtd_times['maximo'], 400);
        }
        // Reseta Campeonato
        $this->campeonatoJogo->where('id_campeonato', $request['id_campeonato'])->delete();

        $retorno   = [];
        $arr_times = [];
        // Quartas de Final
        $sortRequest = [
            'id_campeonato' => $request['id_campeonato'],
            'arr_times' => $arr_times,
        ];
        $sortTimes = $this->campeonatoTime->sortTimes($sortRequest);
        if(count($sortTimes) == 8){
            $arr_times = $this->simulacao($request['id_campeonato'], 'Quartas-Final', $sortTimes);
        }

        //Semi-Final
        $sortRequest = [
            'id_campeonato' => $request['id_campeonato'],
            'arr_times' => $arr_times['vencedor'],
        ];

        $sortTimes = $this->campeonatoTime->sortTimes($sortRequest);
        if(count($sortTimes) == 4){            
            $arr_times = $this->simulacao($request['id_campeonato'], 'Semi-Final', $sortTimes);
        }

        //Terceiro-Lugar
        $sortRequest = [
            'id_campeonato' => $request['id_campeonato'],
            'arr_times' => $arr_times['perdedor'],
        ];
        $sortTimes = $this->campeonatoTime->sortTimes($sortRequest);
        if(count($sortTimes) == 2){
            $terceiro = $this->simulacao($request['id_campeonato'], 'Terceiro-Lugar', $sortTimes);
            $retorno[3] = $terceiro['vencedor'];
        }

        //Final
        $sortRequest = [
            'id_campeonato' => $request['id_campeonato'],
            'arr_times' => $arr_times['vencedor'],
        ];
        $sortTimes = $this->campeonatoTime->sortTimes($sortRequest);
        if(count($sortTimes) == 2){
            $finalistas = $this->simulacao($request['id_campeonato'], 'Final', $sortTimes);
            $retorno[1] = $finalistas['vencedor'];
            $retorno[2] = $finalistas['perdedor'];
        }

        ksort($retorno);

        
        return $retorno;
    }

    private function simulacao($id_campeonato, $fase, $sortTimes = [])
    {
        $i = 0;
        $jogo = [];
        $retorno = [];
        foreach ($sortTimes as $time) {
            $i++;            
            if($i == 1){
                $time_casa = $time->id_time;
            }
            if($i == 2){
                $time_fora = $time->id_time;
                $placar = $this->getPlacar();
                $jogo = [
                    'id_campeonato' => $id_campeonato,
                    'id_time_casa'  => $time_casa,
                    'id_time_fora'  => $time_fora,
                    'placar_time_casa'  => $placar['casa'],
                    'placar_time_fora'  => $placar['fora'],
                    'fase' => $fase,
                ];
                $resultado = $this->getResultado($jogo);
                $retorno['vencedor'][] = $resultado['vencedor'];
                $retorno['perdedor'][] = $resultado['perdedor'];
                $retorno['jogos'][] = $this->campeonatoJogo->create($jogo);
                $i = 0;
            }
        }
    
        return $retorno;
    }
}
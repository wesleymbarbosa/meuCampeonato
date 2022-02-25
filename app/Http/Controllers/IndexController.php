<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Campeonato;
use App\Models\CampeonatoJogo;
use App\Models\CampeonatoTime;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{   
    private $time;
    private $campeonato;
    private $campeonatoJogo;
    private $campeonatoTime;

    public function __construct()
    {
        $this->time = new Time();
        $this->campeonato = new Campeonato();
        $this->campeonatoJogo = new CampeonatoJogo();
        $this->campeonatoTime = new CampeonatoTime();
    }

    public function index()
    {
        $times = $this->time->orderBy('nome', 'asc')->get();

        $camps = $this->campeonato->orderBy('id', 'desc')->get();
        $campeonatos = $this->campeonatos($camps);
        // echo "<pre>".print_r($campeonatos, true)."</pre>";
        // exit;
        return view('index', compact('times', 'campeonatos'));
    }

    private function campeonatos($campeonatos)
    {
        $retorno = [];
        foreach ($campeonatos as $camp) {
            $campeonatoJogo = $this->campeonatoJogo->where('id_campeonato', $camp->id)->get();
            $jogos = [];
            foreach ($campeonatoJogo as $jogo) {
                $casa = $this->time->find($jogo->id_time_casa);
                $fora = $this->time->find($jogo->id_time_fora);
                $jogos[] = [
                    'fase' => $jogo->fase,
                    'time_casa' => $casa->nome,
                    'placar_time_casa' => $jogo->placar_time_casa,
                    'time_fora' => $fora->nome,
                    'placar_time_fora' => $jogo->placar_time_fora,
                ];
            }

            $campeao = $this->time->find($camp->id_time_campeao);
            $vice = $this->time->find($camp->id_time_vice);
            $terceiro = $this->time->find($camp->id_time_terceiro);

            $retorno[$camp->id] = [
                'id' => $camp->id,
                'nome' => $camp->nome,
                'campeao' => $campeao ? $campeao->nome : null,
                'vice' => $vice ? $vice->nome : null,
                'terceiro' => $terceiro ? $terceiro->nome : null,
                'jogos' => $jogos,
            ];

            
        }
        
        return $retorno;
    }
}

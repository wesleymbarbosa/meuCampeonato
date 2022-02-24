<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Time;
use App\Models\Campeonato;

class CampeonatoTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_campeonato' => $this->id_campeonato,
            // 'campeonato' => Campeonato::find($this->id_campeonato),
            'id_time_casa' => $this->id_time_casa,
            'time_casa' => Time::find($this->id_time_casa),
            'id_time_fora' => $this->id_time_fora,
            'time_fora' => Time::find($this->id_time_fora),
            'dt_cadastro' => date('d/m/Y H:i:s', strtotime($this->dt_cadastro)),
        ];
    }
}

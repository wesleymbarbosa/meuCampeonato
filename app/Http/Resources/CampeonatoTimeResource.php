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
            'id_time' => $this->id_time,
            'time' => Time::find($this->id_time),
            'dt_cadastro' => date('d/m/Y H:i:s', strtotime($this->dt_cadastro)),
        ];
    }
}

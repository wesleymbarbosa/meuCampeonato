<?php

namespace App\Http\Controllers;

use App\Models\Campeonato;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Http\Resources\CampeonatoResource;

class CampeonatoController extends Controller
{
    private $validator;

    public function __construct(Campeonato $campeonato)
    {
        $this->campeonato = $campeonato;
        $this->validator = Validator::class;
    }

    public function index()
    {
        $campeonato = $this->campeonato->included()
            ->filter()
            ->sort()
            ->getOrPaginate();

        return CampeonatoResource::collection($campeonato);
    }

    public function store(Request $request)
    {
        $validator = $this->validator::make($request->all(),[
            'nome' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $campeonato = $this->campeonato->create($request->all());
        return $this->show($campeonato->id);
    }

    public function show($id)
    {
        if ($campeonato = $this->campeonato->find($id)) {
            return CampeonatoResource::make($campeonato);
        }
        
        return response()->json('Registro não encontrado', 404);
    }

    public function update(Request $request, Campeonato $campeonato)
    {
        $validator = $this->validator::make($request->all(),[
            'nome' => 'required|string|max:255',
            'dt_cadastro' => 'date',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        
        if ($this->campeonato->find($campeonato->id)) {
            $campeonato->update($request->all());
            return CampeonatoResource::make($campeonato);
        }

        return response()->json('Registro não encontrado', 404); 
    }

    public function destroy(Campeonato $campeonato)
    {
        if($campeonato->delete()){
            return response()->json('Registro excluído com sucesso', 200);
        } else {
            return response()->json('Registro não encontrado', 404); 
        }
    }
}

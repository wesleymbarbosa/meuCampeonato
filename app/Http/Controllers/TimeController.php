<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Http\Resources\TimeResource;

class TimeController extends Controller
{
    private $validator;

    public function __construct(Time $time)
    {
        $this->time = $time;
        $this->validator = Validator::class;
    }

    public function index()
    {
        $time = $this->time->included()
            ->filter()
            ->sort()
            ->getOrPaginate();

        return TimeResource::collection($time);
    }

    public function store(Request $request)
    {
        $validator = $this->validator::make($request->all(),[
            'nome' => 'required|string|max:255',
            'sigla' => 'unique:times',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $time = $this->time->create($request->all());
        return $this->show($time->id);
    }

    public function show($id)
    {
        if ($time = $this->time->find($id)) {
            return TimeResource::make($time);
        }
        
        return response()->json('Registro não encontrado', 404);
    }

    public function update(Request $request, Time $time)
    {
        $validator = $this->validator::make($request->all(),[
            'nome' => 'required|string|max:255',
            'sigla' => 'unique:times,sigla,' . $time->id,
            'dt_cadastro' => 'date',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        if ($this->time->find($time->id)) {
            $time->update($request->all());
            return TimeResource::make($time);
        }

        return response()->json('Registro não encontrado', 404); 
    }

    public function destroy(Time $time)
    {
        if($time->delete()){
            return response()->json('Registro excluído com sucesso', 200);
        } else {
            return response()->json('Registro não encontrado', 404); 
        }
    }
}

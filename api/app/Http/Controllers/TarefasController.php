<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;
use App\Models\Usuario;
use \DateTime;

class TarefasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefas = Tarefa::all();
        $tarefas = Tarefa::orderBy('id', 'desc')->get();
        foreach ($tarefas as $key => $value) {
            $tarefas[$key]['usuario'] = Usuario::findOrFail($value->usuario_id);
            $tarefas[$key]['responsavel'] = $tarefas[$key]['usuario']['nome'];
        }

        return response()->json($tarefas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataEntrega = implode('-', array_reverse(explode('/', $request->entrega)));

        $tarefa = new Tarefa();
        $tarefa->tarefa = $request->tarefa;
        $tarefa->status = 'Nova';
        $tarefa->entrega = new DateTime($dataEntrega);
        $tarefa->usuario_id = $request->usuario;

        $tarefa->save();

        return response()->json(['msg' => 'Tarefa cadastrada com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tarefa = Tarefa::findOrFail($id);

        return $tarefa;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        if ($request->tarefa) {
            $tarefa->tarefa = $request->tarefa;
        }
        if ($request->status) {
            $tarefa->status = $request->status;
        }
        if ($request->entrega) {
            $dataEntrega = implode('-', array_reverse(explode('/', $request->entrega)));
            $tarefa->entrega = new DateTime($dataEntrega);
        }
        if ($request->usuario) {
            $tarefa->usuario_id = $request->usuario;
        }

        $tarefa->save();

        $tarefa->usuario = Usuario::findOrFail($tarefa->usuario_id);

        return response()->json(['msg' => 'Tarefa atualizada com sucesso.', 'tarefa' => $tarefa]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return response()->json(['msg' => 'Tarefa deletada com sucesso.']);
    }
}

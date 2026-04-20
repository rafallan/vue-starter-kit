<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTarefaRequest;
use App\Http\Requests\UpdateTarefaRequest;
use App\Models\Status;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::with(['status', 'users'])->get();

        return Inertia::render('tarefas/Index', [
            'tarefas' => $tarefas
        ]);
    }

    public function create()
    {
        $statuses = Status::all();
        $users = User::all();

        return Inertia::render('tarefas/Create', [
            'statuses' => $statuses,
            'users' => $users
        ]);
    }

    public function store(StoreTarefaRequest $request)
    {
        $validated = $request->validated();
        $tarefa = Tarefa::create($validated);

        if ($request->has('user_ids')) {
            $tarefa->users()->sync($request->user_ids);
        }

        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso.');
    }

    public function edit(Tarefa $tarefa)
    {
        $tarefa->load('users');
        $statuses = Status::all();
        $users = User::all();

        return Inertia::render('tarefas/Edit', [
            'tarefa' => $tarefa,
            'statuses' => $statuses,
            'users' => $users
        ]);
    }

    public function update(UpdateTarefaRequest $request, Tarefa $tarefa)
    {
        $validated = $request->validated();
        $tarefa->update($validated);

        if ($request->has('user_ids')) {
            $tarefa->users()->sync($request->user_ids);
        } else {
            $tarefa->users()->sync([]);
        }

        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso.');
    }

    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();

        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TaskApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(): JsonResponse
    {
        $tasks = Task::orderByDesc('id')->get();
        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $title = $request->input('title');
        $description = $request->input('description');

        if (empty($title) || empty($description)) {
            return response()->json(['message' => 'Título e descrição são obrigatórios!'], 400);
        }

        $checkTaskExists = Task::checkTaskExist($title);

        if ($checkTaskExists) {
            return response()->json(['message' => 'Já temos uma tarefa com esse titulo cadastrado, por favor escolha outro titulo'], 400);
        }

        $task = Task::createTask($title, $description, 'Pendente');

        return response()->json(['message' => 'Tarefa criada com sucesso!', 'task' => $task], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada.'], 404);
        }

        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');

        $checkStatus = Task::checkStatusAvaible($status);

        if (!$checkStatus) {
            return response()->json(['message' => 'Status inválido.'], 400);
        }

        $task->update(['title' => $title, 'description' => $description, 'status' => $status]);

        return response()->json(['message' => 'Tarefa atualizada com sucesso!', 'task' => $task]);
    }

    public function destroy($id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada.'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa excluída com sucesso!']);
    }

    public function changeStatus(Request $request, $id): JsonResponse
    {
        $status = $request->input('status');
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada.'], 404);
        }

        switch ($status) {
            case 'C':
                $task->status = 'Concluído';
                break;
            case 'R':
                $task->status = 'Pendente';
                break;
            case 'E':
                $task->status = 'Em andamento';
                break;
            default:
                return response()->json(['message' => 'Ação inválida.'], 400);
        }

        $task->save();

        return response()->json(['message' => 'Status atualizado com sucesso!']);
    }

    public function searchTasks()
    {
        $search = strip_tags(trim(request()->input('search')));
        $tasks = Task::search($search)->orderBy('id', 'desc')->paginate(10);

        return view('welcome', compact('tasks'));
    }

}

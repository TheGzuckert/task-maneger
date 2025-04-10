@props(['tasks'])

<div class="d-block d-md-none">
    @forelse ($tasks as $task)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $task->id }}</p>
                <p><strong>Título:</strong> {{ $task->title }}</p>
                <p><strong>Descrição:</strong> {{ $task->description }}</p>
                <p><strong>Status:</strong>
                    <span class="badge
                        {{ $task->status === 'Concluído' ? 'bg-success' : ($task->status === 'Em andamento' ? 'bg-primary' : 'bg-warning') }}">
                        {{ $task->status }}
                    </span>
                </p>

                <p><strong>Mudar Status:</strong></p>
                <div class="d-flex gap-2 flex-wrap mb-2">
                    <button class="btn btn-warning btn-sm change-status-btn" data-task-id="{{ $task->id }}" data-status="R" title="Reabrir Tarefa">
                        <i class="fas fa-redo text-white"></i>
                    </button>
                    <button style="background-color: #0d6efd; color: white; border: none; padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.25rem;"
                            class="btn-sm change-status-btn" data-task-id="{{ $task->id }}" data-status="E" title="Em andamento"><i class="fas fa-play"></i>
                    </button>
                    <button class="btn btn-success btn-sm change-status-btn" data-task-id="{{ $task->id }}" data-status="C" title="Concluir Tarefa">
                        <i class="fas fa-check text-white"></i>
                    </button>
                </div>

                <p><strong>Ações:</strong></p>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-info btn-sm" title="Visualizar Tarefa" data-bs-toggle="modal" data-bs-target="#viewModal{{ $task->id }}">
                        <i class="fas fa-eye text-white"></i>
                    </button>
                    <button class="btn btn-secondary btn-sm" title="Editar Tarefa" data-bs-toggle="modal" data-bs-target="#editModal{{ $task->id }}">
                        <i class="fas fa-edit text-white"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" title="Remover Tarefa" data-task-id="{{ $task->id }}" id="deleteTaskBtn{{ $task->id }}">
                        <i class="fas fa-trash text-white"></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted">Nenhuma tarefa cadastrada</div>
    @endforelse
</div>

<div class="table-responsive d-none d-md-block">
    <table class="table table-striped table-bordered align-middle text-nowrap">
        <thead class="table-light text-center">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Mudar Status</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($tasks as $task)
            <tr class="text-center">
                <td>{{ $task->id }}</td>
                <td class="text-start">{{ $task->title }}</td>
                <td class="text-start">{{ $task->description }}</td>
                <td>
                    <span class="badge
                        {{ $task->status === 'Concluído' ? 'bg-success' : ($task->status === 'Em andamento' ? 'bg-primary' : 'bg-warning') }}">
                        {{ $task->status }}
                    </span>
                </td>
                <td>
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                        <button class="btn btn-warning btn-sm change-status-btn" data-task-id="{{ $task->id }}" data-status="R" title="Reabrir Tarefa">
                            <i class="fas fa-redo text-white"></i>
                        </button>
                        <button style="background-color: #0d6efd; color: white; border: none; padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.25rem;"
                                class="btn-sm change-status-btn" data-task-id="{{ $task->id }}" data-status="E" title="Em andamento"><i class="fas fa-play"></i>
                        </button>
                        <button class="btn btn-success btn-sm change-status-btn" data-task-id="{{ $task->id }}" data-status="C" title="Concluir Tarefa">
                            <i class="fas fa-check text-white"></i>
                        </button>
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                        <button class="btn btn-info btn-sm" title="Visualizar Tarefa" data-bs-toggle="modal" data-bs-target="#viewModal{{ $task->id }}">
                            <i class="fas fa-eye text-white"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm" title="Editar Tarefa" data-bs-toggle="modal" data-bs-target="#editModal{{ $task->id }}">
                            <i class="fas fa-edit text-white"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Remover Tarefa" data-task-id="{{ $task->id }}" id="deleteTaskBtn{{ $task->id }}">
                            <i class="fas fa-trash text-white"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Nenhuma tarefa cadastrada</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>


<div class="d-flex justify-content-center mt-4">
    <div style="width: 100%">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </div>
</div>

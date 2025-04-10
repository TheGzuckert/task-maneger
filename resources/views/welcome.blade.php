<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Task Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        nav[aria-label="Pagination Navigation"] > div:first-child {
            display: none !important;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h1 class="display-4">Task Manager</h1>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <form action="{{ route('tasks.search') }}" method="GET" class="d-flex align-items-center">
                <input type="text" class="form-control me-2" id="search" name="search" placeholder="Pesquise uma tarefa" aria-label="Search">
                <button type="submit" class="btn btn-primary btn-sm me-2" title="Pesquisar">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal" title="Adicionar">
                    <i class="fas fa-plus"></i>
                </button>
            </form>
        </div>
    </div>


    <x-table :tasks="$tasks" />


    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Adicionar Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTaskForm">
                        <div class="mb-3">
                            <label for="newTitle" class="form-label">Titulo da Tarefa</label>
                            <input type="text" class="form-control" id="newTitle" name="title" placeholder="Insira aqui o título" required>
                        </div>
                        <div class="mb-3">
                            <label for="newDescription" class="form-label">Descrição da Tarefa</label>
                            <textarea class="form-control" id="newDescription" name="description" placeholder="Insira aqui a descrição" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="addTaskButton">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    @foreach ($tasks as $task)
        <div class="modal fade" id="viewModal{{ $task->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $task->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $task->id }}">Detalhes da Tarefa - {{ $task->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Título:</strong> <span id="taskTitle{{ $task->id }}">{{ $task->title }}</span></p>
                        <p><strong>Descrição:</strong> <span id="taskDescription{{ $task->id }}">{{ $task->description }}</span></p>
                        <p><strong>Status:</strong> <span id="taskStatus{{ $task->id }}">{{ $task->status }}</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($tasks as $task)
        <div class="modal fade" id="editModal{{ $task->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $task->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $task->id }}">Editar Tarefa - {{ $task->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTaskForm{{ $task->id }}">
                            <div class="mb-3">
                                <label for="title{{ $task->id }}" class="form-label">Título</label>
                                <input type="text" class="form-control" id="title{{ $task->id }}" value="{{ $task->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description{{ $task->id }}" class="form-label">Descrição</label>
                                <textarea class="form-control" id="description{{ $task->id }}" required>{{ $task->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status{{ $task->id }}" class="form-label">Status</label>
                                <select class="form-select" id="status{{ $task->id }}">
                                    <option value="Concluído" {{ $task->status === 'Concluído' ? 'selected' : '' }}>Concluído</option>
                                    <option value="Em andamento" {{ $task->status === 'Em andamento' ? 'selected' : '' }}>Em andamento</option>
                                    <option value="Pendente" {{ $task->status === 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="saveChanges{{ $task->id }}" data-task-id="{{ $task->id }}">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


    // Cria Tarefa
    document.getElementById('addTaskButton').addEventListener('click', function () {
        const form = document.getElementById('addTaskForm');
        const title = form.querySelector('#newTitle').value;
        const description = form.querySelector('#newDescription').value;

        fetch('/api/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ title, description })
        })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        throw new Error(data.message || 'Erro desconhecido');
                    }
                    return data;
                });
            })
            .then(data => {
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    const myModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
                    if (myModal) myModal.hide();
                    location.reload();
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                Swal.fire({
                    title: 'Erro!',
                    text: error.message || 'Ocorreu um erro ao adicionar a tarefa.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            });
    });

    // Edita Tarefa
    document.querySelectorAll('.btn-primary').forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-task-id');

            const title = document.getElementById(`title${taskId}`).value;
            const description = document.getElementById(`description${taskId}`).value;
            const status = document.getElementById(`status${taskId}`).value;

            fetch(`/api/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    title,
                    description,
                    status
                })
            })
                .then(response => {
                    if (response.ok) return response.json();
                    return response.json().then(err => { throw err; });
                })
                .then(data => {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById(`editModal${taskId}`));
                        if (modal) modal.hide();
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        title: 'Erro!',
                        text: error.message || 'Erro ao editar tarefa.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                });
        });
    });

    // Excluir Tarefa
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-task-id');

            Swal.fire({
                title: 'Tem certeza?',
                text: `Você irá excluir a tarefa definitivamente`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/tasks/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Erro ao excluir tarefa');
                            }
                        })
                        .then(data => {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao excluir a tarefa.',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        });
                }
            });
        });
    });

    // Altera Status
    document.querySelectorAll('.change-status-btn').forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-task-id');
            const status = this.getAttribute('data-status');

            fetch(`/api/tasks/${taskId}/status`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status })
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Não foi possível atualizar o status.'
                    });
                });
        });
    });
</script>
</body>
</html>

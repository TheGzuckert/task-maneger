<?php

namespace Tests\Unit;

use Tests\TestCase;

class TaskApiTest extends TestCase
{
    public function test_store_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa'
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Tarefa criada com sucesso!']);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
            'status' => 'Pendente'
        ]);
    }
}

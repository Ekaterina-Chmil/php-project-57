<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $status;

    protected function setUp(): void
    {
        parent::setUp();
        // Создаем дефолтных пользователя и статус для тестов
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
    }

    // 1. Тест списка задач
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));
        $response->assertOk();
    }

    // 2. Тест формы создания
    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertOk();
    }

    // 3. Тест успешного сохранения задачи
    public function testStore(): void
    {
        $data = [
            'name' => 'Новая задача',
            'description' => 'Описание задачи',
            'status_id' => $this->status->id,
            'assigned_to_id' => $this->user->id,
        ];

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'name' => 'Новая задача',
            'created_by_id' => $this->user->id, // Проверяем, что создателем стал залогиненный юзер
        ]);
    }

    // 4. Тест просмотра конкретной задачи
    public function testShow(): void
    {
        $task = Task::factory()->create([
            'status_id' => $this->status->id,
            'created_by_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('tasks.show', $task));
        $response->assertOk();
    }

    // 5. Тест формы редактирования
    public function testEdit(): void
    {
        $task = Task::factory()->create([
            'status_id' => $this->status->id,
            'created_by_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('tasks.edit', $task));
        $response->assertOk();
    }

    // 6. Тест обновления задачи
    public function testUpdate(): void
    {
        $task = Task::factory()->create([
            'status_id' => $this->status->id,
            'created_by_id' => $this->user->id,
        ]);

        $data = [
            'name' => 'Измененное имя',
            'status_id' => $this->status->id,
        ];

        $response = $this->actingAs($this->user)->patch(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Измененное имя',
        ]);
    }

    // 7. Тест успешного удаления создателем задачи
    public function testDestroyByCreator(): void
    {
        $task = Task::factory()->create([
            'status_id' => $this->status->id,
            'created_by_id' => $this->user->id, // Создатель — наш текущий $this->user
        ]);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    // 8. Тест: чужой пользователь НЕ МОЖЕТ удалить задачу
    public function testDestroyByNonCreatorFails(): void
    {
        $task = Task::factory()->create([
            'status_id' => $this->status->id,
            'created_by_id' => $this->user->id, // Создатель — первый юзер
        ]);

        $otherUser = User::factory()->create(); // Другой юзер, который пытается удалить

        $response = $this->actingAs($otherUser)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        // Проверяем, что задача осталась в базе данных невредимой
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}

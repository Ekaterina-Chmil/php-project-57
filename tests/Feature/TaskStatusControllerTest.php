<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase; // Очищает базу данных перед каждым тестом

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Создаем пользователя, так как CRUD статусов обычно требует авторизации
        $this->user = User::factory()->create();
    }

    // 1. Тест отображения списка статусов
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.index'));
        $response->assertOk();
    }

    // 2. Тест открытия страницы создания
    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    // 3. Тест успешного сохранения нового статуса
    public function testStore(): void
    {
        $data = ['name' => 'В архиве'];

        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    // 4. Тест открытия страницы редактирования
    public function testEdit(): void
    {
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $status));
        $response->assertOk();
    }

    // 5. Тест успешного обновления статуса
    public function testUpdate(): void
    {
        $status = TaskStatus::factory()->create();
        $data = ['name' => 'Измененный статус'];

        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', $status), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    // 6. Тест успешного удаления статуса
    public function testDestroy(): void
    {
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }
}

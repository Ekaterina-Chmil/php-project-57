<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        // Создаём пользователя и тестовую метку
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    // 1. Тест просмотра списка меток
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.index'));
        $response->assertOk();
    }

    // 2. Тест формы создания метки
    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
    }

    // 3. Тест успешного сохранения новой метки
    public function testStore(): void
    {
        $data = [
            'name' => 'Уникальная метка',
            'description' => 'Описание новой метки',
        ];

        $response = $this->actingAs($this->user)->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['name' => 'Уникальная метка']);
    }

    // 4. Тест формы редактирования
    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label));
        $response->assertOk();
    }

    // 5. Тест обновления метки
    public function testUpdate(): void
    {
        $data = [
            'name' => 'Измененное имя',
            'description' => 'Новое описание',
        ];

        $response = $this->actingAs($this->user)->patch(route('labels.update', $this->label), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', [
            'id' => $this->label->id,
            'name' => 'Измененное имя',
        ]);
    }

    // 6. Тест успешного удаления СВОБОДНОЙ метки
    public function testDestroySuccess(): void
    {
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $this->label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }

    // 7. Метку, связанную с задачей, УДАЛИТЬ НЕЛЬЗЯ
    public function testDestroyLinkedLabelFails(): void
    {
        // Создаем инфраструктуру для задачи
        $status = TaskStatus::factory()->create();
        
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'created_by_id' => $this->user->id,
        ]);

        // Привязываем нашу метку к созданной задаче
        $task->labels()->attach($this->label->id);

        // Пытаемся удалить привязанную метку
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $this->label));

        $response->assertRedirect(route('labels.index'));
        // Проверяем, что метка ОСТАЛАСЬ в базе данных невредимой по ТЗ
        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }
}

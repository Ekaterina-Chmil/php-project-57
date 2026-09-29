<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $status = TaskStatus::first();

        if ($user && $status) {
            $taskNames = [
                'Исправить ошибку при входе на сайт',
                'Добавить кнопку «Поиск по фото»',
                'Сделать дизайн главной страницы для мобильных',
                'Проверить, почему не отправляются письма на почту',
                'Добавить новые метки для фильтрации задач'
            ];

            foreach ($taskNames as $name) {
                Task::factory()->create([
                    'name' => $name,
                    'status_id' => $status->id,
                    'created_by_id' => $user->id,
                ]);
            }
        }
    }
}

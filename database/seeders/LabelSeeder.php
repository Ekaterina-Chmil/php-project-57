<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Label;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            [
                'name' => 'ошибка',
                'description' => 'Критические баги и поломки, которые нужно чинить в первую очередь'
            ],
            [
                'name' => 'доработка',
                'description' => 'Новые функции или улучшения, предложенные заказчиком'
            ],
            [
                'name' => 'маркетинг',
                'description' => 'Задачи, связанные с рекламой, продвижением и текстами'
            ],
            [
                'name' => 'срочно',
                'description' => 'Горящие задачи с близким дедлайном'
            ],
        ];

        foreach ($labels as $labelData) {
            Label::create($labelData);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Связь: у одного статуса может быть много задач
     */
    public function tasks(): HasMany
    {
        // Связываем статус с моделью Task по внешнему ключу status_id
        return $this->hasMany(Task::class, 'status_id');
    }
}

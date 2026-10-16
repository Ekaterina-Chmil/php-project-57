<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id',
    ];

    // Связь: задача принадлежит статусу
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    // Связь: задача создана пользователем
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Связь: задача назначена пользователю
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function labels(): BelongsToMany
    {
        // Указываем связующую таблицу task_label
        return $this->belongsToMany(Label::class, 'task_label');
    }
}

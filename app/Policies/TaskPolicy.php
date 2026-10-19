<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Удалять можно только если ID текущего юзера совпадает с создателем задачи
        return $user->id === $task->created_by_id;
    }
}

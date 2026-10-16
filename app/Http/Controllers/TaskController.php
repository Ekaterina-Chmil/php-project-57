<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        // Получаем списки для выпадающих меню фильтра [id => name]
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        $tasks = QueryBuilder::for(Task::class)
            ->with(['status', 'createdBy', 'assignedTo', 'labels'])
            ->allowedFilters(
                AllowedFilter::exact('status_id')->ignore(''),
                AllowedFilter::exact('created_by_id')->ignore(''),
                AllowedFilter::exact('assigned_to_id')->ignore(''),
            )
            ->paginate(15)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'statuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact('statuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();

        $task = Auth::user()->createdTasks()->create($data);

        // Синхронизируем метки с задачей (если они были выбраны)
        if ($request->has('labels')) {
            $task->labels()->sync($request->input('labels'));
        }

        flash(__('Задача успешно создана'))->success();

            return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->update($data);

        // Обновляем связи в связующей таблице
        $task->labels()->sync($request->input('labels', []));

        flash(__('Задача успешно изменена'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Проверяем права через политику TaskPolicy (метод delete)
        $this->authorize('delete', $task);

        $task->delete();

        flash(__('Задача успешно удалена'))->success();

        return redirect()->route('tasks.index');
    }
}

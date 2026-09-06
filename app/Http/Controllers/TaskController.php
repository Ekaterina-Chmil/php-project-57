<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Получаем списки для выпадающих меню фильтра [id => name]
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        $filters = array_filter($request->input('filter', []), function ($value) {
            return $value !== null && $value !== '';
        });

        // Подменяем очищенный массив в запрос, чтобы Spatie видел только заполненные поля
        $request->merge(['filter' => $filters]);

        // Используем QueryBuilder вместо обычного Task::query()
        $tasks = QueryBuilder::for(Task::class)
            ->with(['status', 'creator', 'assignee', 'labels'])
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
                // Фильтрация по меткам через связующую таблицу (многие-ко-многим)
                AllowedFilter::exact('labels', 'labels.id'),
            )
            ->paginate(15)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'statuses', 'users', 'labels'));
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
        ]);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = Auth::id();
        $task->save();

        // Синхронизируем метки с задачей (если они были выбраны)
        if ($request->has('labels')) {
            $task->labels()->sync($request->input('labels'));

            flash(__('Задача успешно создана'))->success();

            return redirect()->route('tasks.index');
        }
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
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
        ]);

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
        // Наша фишка: проверяем, что удаляет именно создатель задачи
        if ($task->created_by_id !== Auth::id()) {
            flash(__('Не удалось удалить задачу'))->error();
            return redirect()->route('tasks.index');
        }

        $task->delete();

        flash(__('Задача успешно удалена'))->success();

        return redirect()->route('tasks.index');
    }
}

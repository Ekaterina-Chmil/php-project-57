<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Начинаем запрос к задачам и сразу подгружаем связи (чтобы не было N+1)
        $query = Task::with(['status', 'creator', 'assignee']);

        // Фильтрация (если в форме выбрали фильтр)
        if ($request->filled('filter.status_id')) {
            $query->where('status_id', $request->input('filter.status_id'));
        }

        if ($request->filled('filter.created_by_id')) {
            $query->where('created_by_id', $request->input('filter.created_by_id'));
        }

        if ($request->filled('filter.assigned_to_id')) {
            $query->where('assigned_to_id', $request->input('filter.assigned_to_id'));
        }

        // Пагинация по 15 задач на страницу + сохраняем параметры фильтра в ссылках пагинации
        $tasks = $query->paginate(15)->withQueryString();

        return view('tasks.index', compact('tasks', 'statuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('tasks.create', compact('statuses', 'users'));
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
        ]);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = Auth::id(); // Наша фишка: текущий юзер становится создателем
        $task->save();

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

        return view('tasks.edit', compact('task', 'statuses', 'users'));
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
        ]);

        $task->update($data);

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

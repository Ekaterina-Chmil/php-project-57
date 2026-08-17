<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = \App\Models\TaskStatus::all(); // Получаем все статусы из БД
        return view('task_statuses.index', compact('taskStatuses')); // Показываем представление
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация: поле name обязательно и должно быть строкой
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:task_statuses,name',
        ]);

        // Создаем новый статус
        $taskStatus = TaskStatus::create($validated);

        // Показываем флеш-сообщение и перенаправляем на список
        flash()->success('Статус успешно создан');
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:task_statuses,name,' . $taskStatus->id,
        ]);

        $taskStatus->update($validated);

        flash('Статус успешно изменен')->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        // Удаляем статус
        $taskStatus->delete();

        // Показываем флеш
        flash(__('Статус успешно удален'))->success();

        // Возвращаем на список
        return redirect()->route('task_statuses.index');
    }
}

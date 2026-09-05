<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:labels,name',
            'description' => 'nullable|string',
        ]);

        Label::create($data);

        flash(__('Метка успешно создана'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:labels,name,' . $label->id,
            'description' => 'nullable|string',
        ]);

        $label->update($data);

        flash(__('Метка успешно изменена'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        // Проверяем, привязана ли метка к задачам
        if ($label->tasks()->exists()) {
            flash(__('Не удалось удалить метку'))->error();
            return redirect()->route('labels.index');
        }

        try {
            $label->delete();
            flash(__('Метка успешно удалена'))->success();
        } catch (\Illuminate\Database\QueryException $e) {
            flash(__('Не удалось удалить метку'))->error();
        }

        return redirect()->route('labels.index');
    }
}

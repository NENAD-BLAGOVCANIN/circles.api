<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'team_id' => 'required|exists:teams,id',
            'assignedTo' => 'required|exists:users,id',
        ]);

        // Create a new task
        $task = Task::create($validatedData);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        // Find a task by ID
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'team_id' => 'required|exists:teams,id',
            'assignedTo' => 'required|exists:users,id',
        ]);

        // Find the task by ID and update
        $task = Task::findOrFail($id);
        $task->update($validatedData);

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        // Find the task by ID and delete
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::with('assignee')->where('team_id', '=', auth()->user()->currently_selected_team_id)->orderBy('id', 'desc')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Task::create($validatedData);
        $task->team_id = auth()->user()->currently_selected_team_id;
        $task->status = Task::STATUS_TODO;
        $task->save();

        return response()->json($task, 201);
    }

    public function assign(Request $request){
        $assignee_id = $request->get('assignee_id');
        $task_id = $request->get('task_id');

        $task = Task::findOrFail($task_id);
        $task->assigned_to = $assignee_id;
        $task->save();

        return response()->json($task, 201);
    }

    public function show($id)
    {
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
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|string'
        ]);

        $task = Task::findOrFail($id);
        $task->update($validatedData);

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        $projects = Project::all();
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'project_id' => 'required|exists:projects,id'
        ]);

        $task = Task::create([
            'name' => $request->name,
            'priority' => Task::count() + 1,
            'project_id' => $request->project_id
        ]);

        return response()->json($task);
    }

    public function updatePriorities(Request $request)
    {
        $taskIds = $request->task_ids;
        $priority = 1;

        foreach ($taskIds as $taskId) {
            $task = Task::find($taskId);
            $task->update([
                'priority' => $priority
            ]);
            $priority++;
        }

        $tasks = Task::orderBy('priority')->get();
        return response()->json($tasks);
        // return response()->json(['message' => 'Task priorities updated successfully.']);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
            'project_id' => 'required|exists:projects,id'
        ]);

        $task->update([
            'name' => $request->name,
            'project_id' => $request->project_id
        ]);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('home')->with('success', 'Task deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Phase;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{

    public function kanban()
    {
        return view('tasks.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Phase::with('tasks.user')
            ->leftJoin('tasks', 'phases.id', '=', 'tasks.phase_id')
            ->select(DB::raw('count(tasks.id) as task_count, phases.*'))
            ->groupBy('phases.id')->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Create a new task from the $request
        $task = Task::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ($task) {
            $date = $task->completed_at;
            $phases = Phase::where('id', $request->phase_id)->first();
            if ($phases->is_completion && $task->completed_at == null) {
                $date = date('d-m-Y h:i:s');
            }
            

            Task::with('user')->where('id', $task->id)->update([
                'name' => $request->name ? $request->name: $task->name,
                'phase_id' => $request->phase_id ? $request->phase_id: $task->phase_id,
                'user_id' => $request->user_id ? $request->user_id: $task->user_id,
                'completed_at' => $date,
            ]);
        }
        return Task::with('user')->where('id', $task->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Task::destroy($task->id);
    }
}

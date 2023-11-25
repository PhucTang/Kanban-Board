<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Phase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


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
        return Phase::with(['tasks.user' => function ($q){
                $q->orderBy('order_number');
            }])
            ->leftJoin('tasks', 'phases.id', '=', 'tasks.phase_id')
            ->select(DB::raw('count(tasks.id) as task_count, phases.*'))
            ->groupBy('phases.id')->orderBy('phases.order_number', 'ASC')->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users(Request $request)
    {
        $page = $request->query('page');
        $limit = $request->query('limit');
        $offset = $limit * $page;
        return DB::table('users')->offset($offset)->limit($limit)->get();
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
            // check and save completion 
            $date = $task->completed_at;
            $phases = Phase::where('id', $request->phase_id)->first();
            if ($phases->is_completion && $task->completed_at == null) {
                $date = date('d-m-Y h:i:s');
            }
           
            if ($request->old_phase_id && $request->phase_id != $request->old_phase_id) {
                $chunks = DB::table('tasks')->where('phase_id', $request->phase_id)
                ->orderBy('tasks.order_number', 'ASC')
                ->chunkById(100, function (Collection $tasks) use ($request) {
                    foreach ($tasks as $tempTask) {
                        if ($tempTask->order_number >= $request->order_number) {
                            Task::where([
                                'id' => $tempTask->id,
                            ])->update([
                                'order_number' => $tempTask->order_number + 1,
                            ]);
                        }
                    }
                });

                $oldChunks = DB::table('tasks')->where('phase_id', $request->old_phase_id)
                ->orderBy('tasks.order_number', 'ASC')
                ->chunkById(100, function (Collection $tasks) use ($task) {
                    foreach ($tasks as $tempTask) {
                        if ($tempTask->order_number > $task->order_number) {
                            Task::where([
                                'id' => $tempTask->id,
                            ])->update([
                                'order_number' => $tempTask->order_number - 1,
                            ]);
                        }
                    }
                });
            } else {
                // change order_number in the same phase 
                if ($request->phase_id == $request->old_phase_id) {
                    Task::where([
                        'phase_id' => $request->phase_id,
                        'order_number' => $request->order_number,
                    ])->update([
                        'order_number' => $request->old_order_number,
                    ]);
                } 
            }

            Task::where('id', $task->id)->update([
                'name' => $request->name ? $request->name: $task->name,
                'phase_id' => $request->phase_id ? $request->phase_id: $task->phase_id,
                'user_id' => $request->user_id ? $request->user_id: $task->user_id,
                'order_number' => $request->order_number ? $request->order_number: $task->order_number,
                'completed_at' => $date,
            ]);
           
            return Task::with('user')->where('id', $task->id)->first();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Task::destroy($task->id);
    }
}

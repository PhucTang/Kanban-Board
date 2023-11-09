<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Models\Phase;
use Illuminate\Support\Facades\DB;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePhaseRequest $request)
    {
        $phase = Phase::create(["name" => $request->name]);
        return Phase::with('tasks.user')
            ->leftJoin('tasks', 'phases.id', '=', 'tasks.phase_id')
            ->where("phases.id", $phase->fresh()->id)
            ->select(DB::raw('count(tasks.id) as task_count, phases.*'))
            ->groupBy('phases.id')->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(Phase $phase)
    {
        return $phase->load('tasks.user')->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        if ($phase) {
            Phase::where('id', $phase->id)->update([
                'name' => $request->name ? $request->name: $phase->name,
                'is_completion' => $request->is_completion ? $request->is_completion : false
            ]);
        }
        return Phase::with('tasks.user')->where('id', $phase->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        Phase::destroy($phase->id);
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\TaskExtra;
use App\Models\TaskNote;

class TasksController extends Controller
{
    /**
     * Dashboard
     * 
     * @return mixed
     */
    public function dashboard()
    {
        $tasks = Task::where('user_id', auth()->user()->id)
            ->orderBy('grouped_date', 'desc')
            ->orderBy('position', 'asc')
            ->get()
            ->groupBy('grouped_date');
        $extraTasks = TaskExtra::where('user_id', auth()->user()->id)
            ->orderBy('grouped_date', 'desc')
            ->orderBy('position', 'asc')
            ->get()
            ->groupBy('grouped_date');
        $notesByDate = TaskNote::where('user_id', auth()->user()->id)
            ->orderBy('grouped_date', 'desc')
            ->get()
            ->groupBy('grouped_date');

        $today = Carbon::today()->format('Y-m-d');
        $todayFull = $today . ' 00:00:00';

        return view('tasks/dashboard', compact(
            'tasks',
            'extraTasks',
            'today',
            'todayFull',
            'notesByDate',
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

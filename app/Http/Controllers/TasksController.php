<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\TaskExtra;
use App\Models\TaskNote;
use App\Models\TaskPhoto;

class TasksController extends Controller
{
    /**
     * Dashboard
     * 
     * @return mixed
     */
    public function dashboard()
    {
        $tasks = Task::getDashboardTasks();
        $extraTasks = TaskExtra::getDashboardTasks();
        $notesByDate = TaskNote::where('user_id', auth()->user()->id)
            ->where('grouped_date', '>=', date('Y-m-d', strtotime('-14 days')))
            ->orderBy('grouped_date', 'desc')
            ->get()
            ->groupBy('grouped_date')
            ->toBase();
        $photosByDate = TaskPhoto::where('user_id', auth()->user()->id)
            ->where('grouped_date', '>=', date('Y-m-d', strtotime('-14 days')))
            ->orderBy('grouped_date', 'desc')
            ->get()
            ->groupBy('grouped_date')
            ->toBase();

        $today = Carbon::today()->format('Y-m-d');
        $todayFull = $today . ' 00:00:00';

        return view('tasks/dashboard', compact(
            'tasks',
            'extraTasks',
            'today',
            'todayFull',
            'notesByDate',
            'photosByDate',
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

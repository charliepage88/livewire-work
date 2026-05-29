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
            ->orderBy('grouped_date', 'desc')
            ->get()
            ->groupBy('grouped_date')
            ->toBase();
        $photosByDate = TaskPhoto::where('user_id', auth()->user()->id)
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
     * View all tasks, grouped into Monday–Friday workweeks (newest first).
     * Weekend-dated tasks are excluded.
     *
     * @return mixed
     */
    public function all()
    {
        $userId = auth()->user()->id;
        $weeks = [];

        $ingest = function ($rows, string $bucket) use (&$weeks) {
            foreach ($rows as $row) {
                $date = Carbon::parse($row->grouped_date);

                if ($date->isWeekend()) {
                    continue;
                }

                $weekStart = $date->copy()->startOfWeek(Carbon::MONDAY);
                $weekKey = $weekStart->format('Y-m-d');
                $dayKey = $date->format('Y-m-d');

                if (! isset($weeks[$weekKey])) {
                    $weeks[$weekKey] = [
                        'label' => $weekStart->format('M j') . ' – ' . $weekStart->copy()->addDays(4)->format('M j, Y'),
                        'days'  => [],
                    ];
                }

                $weeks[$weekKey]['days'][$dayKey][$bucket][] = $row;
            }
        };

        $ingest(Task::where('user_id', $userId)->orderBy('position', 'asc')->get(), 'tasks');
        $ingest(TaskExtra::where('user_id', $userId)->orderBy('position', 'asc')->get(), 'extras');

        // Newest week first, newest day first within each week.
        krsort($weeks);
        foreach ($weeks as &$week) {
            krsort($week['days']);
        }
        unset($week);

        return view('tasks/all', compact('weeks'));
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

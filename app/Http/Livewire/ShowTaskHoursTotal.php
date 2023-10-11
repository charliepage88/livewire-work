<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Task;
use App\Models\TaskExtra;

use Arr;

class ShowTaskHoursTotal extends Component
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var Collection
     */
    public $tasks;

    /**
     * @var Collection
     */
    public $extraTasks;

    /**
     * @var array
     */
    protected $listeners = [
        'taskUpdate' => 'refreshTasks'
    ];

    /**
     * Refresh Tasks
     * 
     * @return void
     */
    public function refreshTasks()
    {
        $newTasks = Task::getDashboardTasks();

        if (Arr::has($newTasks, $this->date)) {
            $newTasks = $newTasks[$this->date];
        }

        $this->tasks = $newTasks;
        $this->extraTasks = TaskExtra::getDashboardTasks();
    }

    /**
     * Get Total Hours Property
     * 
     * @return float
     */
    public function getTotalHoursProperty()
    {
        $taskHours = $this->tasks
            // ->filter(function ($task) {
            //     return is_array($task) ? $task['is_done'] : $task->is_done;
            // })
            ->sum(function ($task) {
                return floatval(is_array($task) ? $task['hours'] : $task->hours);
            });

        if (Arr::has($this->extraTasks, $this->date)) {
            $extraTaskHours = $this->extraTasks[$this->date]
                // ->filter(function ($task) {
                //     return $task->is_done;
                // })
                ->sum(function ($task) {
                    return floatval($task->hours);
                });

            return $taskHours + $extraTaskHours;
        } else {
            return $taskHours;
        }
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.show-task-hours-total');
    }
}

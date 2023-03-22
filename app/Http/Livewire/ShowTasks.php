<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Task;

class ShowTasks extends Component
{
    public Task $task;

    protected $rules = [
        'task.label'        => 'required|string|min:5|max:50',
        'task.hours'        => 'required|min:1|max:5',
        'task.grouped_date' => 'required',
        'task.is_done'      => 'sometimes',
        'task.is_time_in'   => 'sometimes',
    ];

    public function render()
    {
        return view('livewire.show-tasks');
    }
}

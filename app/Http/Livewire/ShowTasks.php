<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Task;

class ShowTasks extends Component
{
    /**
     * @var Task
     */
    public Task $task;

    /**
     * @var bool
     */
    public $is_editing = false;

    /**
     * @var bool
     */
    public $is_deleting = false;

    /**
     * @var array
     */
    protected $rules = [
        'task.label'        => 'required|string|min:5|max:50',
        'task.hours'        => 'required|min:1|max:5',
        'task.grouped_date' => 'required',
        'task.is_done'      => 'sometimes',
        'task.is_time_in'   => 'sometimes',
    ];

    /**
     * Edit Task
     * 
     * @return void
     */
    public function editTask()
    {
        $this->is_editing = !$this->is_editing;
    }

    /**
     * Delete Task
     * 
     * @return void
     */
    public function deleteTask()
    {
        $this->is_deleting = !$this->is_deleting;
    }

    /**
     * Delete
     * Deletes the task
     * 
     * @return Redirect
     */
    public function delete()
    {
        // delete the task
        $this->task->delete();

        // set flash message
        session()->flash('message', 'Task successfully deleted.');

        return redirect()->to('/dashboard');
    }

    /**
     * Save
     * 
     * @return Redirect
     */
    public function save()
    {
        // validation
        $this->validate();

        // save task
        $this->task->save();

        // set flash message
        session()->flash('message', 'Task successfully saved.');

        return redirect()->to('/dashboard');
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.show-tasks');
    }
}

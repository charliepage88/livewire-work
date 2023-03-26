<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TaskExtra;

class ShowTasksExtra extends Component
{
    /**
     * @var TaskExtra
     */
    public TaskExtra $extraTask;

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
        'extraTask.label'        => 'required|string|min:5|max:50',
        'extraTask.hours'        => 'required|min:1|max:5',
        'extraTask.grouped_date' => 'required',
        'extraTask.is_done'      => 'sometimes',
        'extraTask.is_time_in'   => 'sometimes',
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
     * Deletes the extra task
     * 
     * @return Redirect
     */
    public function delete()
    {
        // delete the extra task
        $this->extraTask->delete();

        // set flash message
        session()->flash('message', 'Extra Task successfully deleted.');

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
        $this->extraTask->save();

        // set flash message
        session()->flash('message', 'Extra Task successfully saved.');

        return redirect()->to('/dashboard');
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.show-tasks-extra');
    }
}

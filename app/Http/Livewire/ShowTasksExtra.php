<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TaskExtra;

class ShowTasksExtra extends Component
{
    /**
     * @var Collection
     */
    public $tasks;

    /**
     * @var mixed
     */
    public $is_editing = null;

    /**
     * @var mixed
     */
    public $is_deleting = null;

    /**
     * @var array
     */
    protected $rules = [
        'tasks.*.label'        => 'required|string|min:5|max:50',
        'tasks.*.hours'        => 'required|min:1|max:5',
        'tasks.*.grouped_date' => 'required',
        'tasks.*.is_done'      => 'sometimes',
        'tasks.*.is_time_in'   => 'sometimes',
    ];

    /**
     * Edit Task
     * 
     * @param int $task_id
     * 
     * @return void
     */
    public function editTask(int $task_id)
    {
        if ($task_id !== $this->is_editing) {
            $this->is_editing = $task_id;
        } else {
            $this->is_editing = null;
        }
    }

    /**
     * Delete Task
     * 
     * @param int $task_id
     * 
     * @return void
     */
    public function deleteTask(int $task_id)
    {
        if ($task_id !== $this->is_deleting) {
            $this->is_deleting = $task_id;
        } else {
            $this->is_deleting = null;
        }
    }

    /**
     * Delete
     * Deletes the extra task
     * 
     * @return Redirect
     */
    public function delete()
    {
        if (!$this->is_deleting) {
            abort(500, 'Empty extra task ID when trying to delete :(');
        }

        // delete the extra task
        $this->tasks->find($this->is_deleting)->delete();

        $this->tasks = $this->tasks->fresh();

        // set flash message
        session()->flash('message', 'Extra Task successfully deleted.');

        $this->is_deleting = null;
    }

    /**
     * Save
     * 
     * @return Redirect
     */
    public function save()
    {
        if (!$this->is_editing) {
            abort(500, 'No edit ID found when clicking save :(');
        }

        // validation
        $this->validate();

        // save task
        $this->tasks->find($this->is_editing)->save();

        $this->tasks = $this->tasks->fresh();

        // set flash message
        session()->flash('message', 'Extra Task successfully saved.');

        $this->is_editing = null;
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

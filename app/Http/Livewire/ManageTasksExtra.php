<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TaskExtra;

class ManageTasksExtra extends Component
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var bool
     */
    public $canCreate = true;

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
     * @var array
     */
    public $task = [
        'label'        => '',
        'is_done'      => false,
        'is_time_in'   => false,
        'hours'        => 0,
        'grouped_date' => '',
    ];

    /**
     * Mount
     * 
     * @param string $date
     * 
     * @return void
     */
    public function mount($date)
    {
        $this->task['grouped_date'] = $date;
    }

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
     * @return void
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
     * @return void
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
     * Create
     * 
     * @return void
     */
    public function create()
    {
        // validation
        $this->validate([
            'task.label' => 'required|string|min:5|max:50',
            'task.hours' => 'required|min:1|max:5',
        ]);

        // save extra task
        $task = new TaskExtra;

        $task->fill($this->task);

        $task->user_id = auth()->user()->id;
        $task->grouped_date = $this->date;

        $task->save();

        // set flash message
        session()->flash('message', 'Extra Task successfully created.');

        if (is_array($this->tasks)) {
            $this->tasks = collect([]);
        }

        $this->tasks->push($task);

        $this->task = [
            'label'        => '',
            'is_done'      => false,
            'is_time_in'   => false,
            'hours'        => 0,
        ];
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.manage-tasks-extra');
    }
}

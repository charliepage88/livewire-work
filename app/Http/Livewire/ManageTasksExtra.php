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
     * Holds the editable values for the row currently being edited.
     *
     * Livewire 4 serializes Eloquent models/collections to the frontend by
     * reference (class + key) rather than by value, so binding wire:model
     * straight to $tasks.*.label yields empty inputs. We copy the row's
     * values into this plain array on edit so they round-trip to the browser.
     *
     * @var array
     */
    public $editForm = [];

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

            $task = collect($this->tasks)->firstWhere('id', $task_id);

            $this->editForm = [
                'label'      => $task['label'],
                'hours'      => $task['hours'],
                'is_done'    => (bool) $task['is_done'],
                'is_time_in' => (bool) $task['is_time_in'],
            ];
        } else {
            $this->is_editing = null;
            $this->editForm = [];
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
        if (get_class($this->tasks) === 'Illuminate\Database\Eloquent\Collection') {
            $is_collection = true;
            $task = $this->tasks->find($this->is_deleting);
        } else {
            $is_collection = false;
            $task = TaskExtra::find($this->is_deleting);
        }

        $task->delete();

        if ($is_collection) {
            $this->tasks = $this->tasks->fresh();
        } else {
            $this->tasks = TaskExtra::where('grouped_date', $this->date)->get();
        }

        // set flash message
        session()->flash('message', 'Extra Task successfully deleted.');

        $this->is_deleting = null;

        $this->dispatch('taskUpdate');
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
        $this->validate([
            'editForm.label'      => 'required|string|min:5|max:50',
            'editForm.hours'      => 'required|min:1|max:5',
            'editForm.is_done'    => 'sometimes',
            'editForm.is_time_in' => 'sometimes',
        ]);

        // save task
        $saveTask = TaskExtra::find($this->is_editing);

        $saveTask->fill([
            'label'      => $this->editForm['label'],
            'hours'      => $this->editForm['hours'],
            'is_done'    => $this->editForm['is_done'],
            'is_time_in' => $this->editForm['is_time_in'],
        ]);

        if (!$saveTask->user_id) {
            $saveTask->user_id = auth()->user()->id;
        }

        $saveTask->save();

        $this->tasks = TaskExtra::where('grouped_date', $this->date)->get();

        // set flash message
        session()->flash('message', 'Extra Task successfully saved.');

        $this->is_editing = null;
        $this->editForm = [];

        $this->dispatch('taskUpdate');
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

        $this->dispatch('taskUpdate');
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

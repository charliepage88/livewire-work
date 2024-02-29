<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Task;

class CreateTask extends Component
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var array
     */
    public $task = [
        'label'        => '',
        'is_done'      => false,
        'is_time_in'   => false,
        'hours'        => '',
        'grouped_date' => '',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'task.label' => 'required|string|min:5|max:50',
        'task.hours' => 'required|min:1|max:5',
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
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.create-task');
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
        $task = new Task;

        $task->fill($this->task);

        $task->user_id = auth()->user()->id;

        $task->save();

        // set flash message
        session()->flash('message', 'Task successfully saved.');

        return redirect()->to('/dashboard');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TaskExtra;

class CreateExtraTask extends Component
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var array
     */
    public $extraTask = [
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
        'extraTask.label' => 'required|string|min:5|max:50',
        'extraTask.hours' => 'required|min:1|max:5',
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
        $this->extraTask['grouped_date'] = $date;
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.create-extra-task');
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
        $extraTask = new TaskExtra;

        $extraTask->fill($this->extraTask);

        $extraTask->user_id = auth()->user()->id;

        $extraTask->save();

        // set flash message
        session()->flash('message', 'Extra Task successfully saved.');

        return redirect()->to('/dashboard');
    }
}

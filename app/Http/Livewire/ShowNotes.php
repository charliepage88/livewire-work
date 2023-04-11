<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TaskNote;

class ShowNotes extends Component
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var Collection
     */
    public $notes;

    /**
     * @var array
     */
    public $newNote = [
        'body'         => '',
        'grouped_date' => '',
    ];

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
        'notes.*.grouped_date' => 'required',
        'notes.*.body'         => 'required',
    ];

    /**
     * Mount
     * 
     * @param string $date
     * 
     * @return void
     */
    public function mount($date = null)
    {
        if (!empty($date)) {
            $this->newNote['grouped_date'] = $date;
        }
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.show-notes');
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

        // save task note
        $this->notes->find($this->is_editing)->save();

        // set flash message
        session()->flash('message', 'Task note successfully saved.');

        $this->is_editing = null;
    }

    /**
     * Edit Note
     * 
     * @return void
     */
    public function editNote($note)
    {
        if ($note !== $this->is_editing) {
            $this->is_editing = $note;
        } else {
            $this->is_editing = null;
        }
    }

    /**
     * Delete Note
     * 
     * @return void
     */
    public function deleteNote($note)
    {
        if ($note !== $this->is_deleting) {
            $this->is_deleting = $note;
        } else {
            $this->is_deleting = null;
        }
    }

    /**
     * Delete
     * Deletes the task note
     * 
     * @return Redirect
     */
    public function delete()
    {
        if (!$this->is_deleting) {
            abort(500, 'Empty note ID when trying to delete :(');
        }

        // delete the task note
        $this->notes->find($this->is_deleting)->delete();

        $this->notes = $this->notes->fresh();

        // set flash message
        session()->flash('message', 'Task note successfully deleted.');

        $this->is_deleting = null;
    }

    /**
     * Create
     * 
     * @return void
     */
    public function create()
    {
        $validatedData = $this->validate([
            'newNote.body' => 'required',
        ]);

        // save task note
        $note = new TaskNote;

        $note->fill($this->newNote);

        $note->user_id = auth()->user()->id;

        $note->save();

        // set flash message
        session()->flash('message', 'Task note successfully saved.');

        if (is_array($this->notes)) {
            $this->notes = collect([]);
        }

        $this->notes->push($note);

        $this->newNote['body'] = '';
    }
}

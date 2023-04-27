<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TaskNote;

class ManageNotes extends Component
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
    public $notes;

    /**
     * @var array
     */
    public $note = [
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
            $this->note['grouped_date'] = $date;
        }
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

        // save task note
        if (get_class($this->notes) === 'Illuminate\Database\Eloquent\Collection') {
            $is_collection = true;
        } else {
            $is_collection = false;
        }

        $this->notes->find($this->is_editing)->save();

        if ($is_collection) {
            $this->notes = $this->notes->fresh();
        } else {
            $this->notes = TaskNote::where('grouped_date', $this->date)->get();
        }

        // set flash message
        session()->flash('message', 'Task note successfully saved.');

        $this->is_editing = null;
    }

    /**
     * Edit Note
     * 
     * @param int $note_id
     * 
     * @return void
     */
    public function editNote(int $note_id)
    {
        if ($note_id !== $this->is_editing) {
            $this->is_editing = $note_id;
        } else {
            $this->is_editing = null;
        }
    }

    /**
     * Delete Note
     * 
     * @param int $note_id
     * 
     * @return void
     */
    public function deleteNote(int $note_id)
    {
        if ($note_id !== $this->is_deleting) {
            $this->is_deleting = $note_id;
        } else {
            $this->is_deleting = null;
        }
    }

    /**
     * Delete
     * Deletes the task note
     * 
     * @return void
     */
    public function delete()
    {
        if (!$this->is_deleting) {
            abort(500, 'Empty note ID when trying to delete :(');
        }

        // delete the task note
        if (get_class($this->notes) === 'Illuminate\Database\Eloquent\Collection') {
            $is_collection = true;
            $note = $this->notes->find($this->is_deleting);
        } else {
            $is_collection = false;
            $note = TaskNote::find($this->is_deleting);
        }

        $note->delete();

        if ($is_collection) {
            $this->notes = $this->notes->fresh();
        } else {
            $this->notes = TaskNote::where('grouped_date', $this->date)->get();
        }

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
        $this->validate([
            'note.body' => 'required',
        ]);

        // save task note
        $note = new TaskNote;

        $note->fill($this->note);

        $note->user_id = auth()->user()->id;

        $note->save();

        // set flash message
        session()->flash('message', 'Task note successfully saved.');

        if (is_array($this->notes)) {
            $this->notes = collect([]);
        }

        $this->notes->push($note);

        $this->note['body'] = '';
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.manage-notes');
    }
}

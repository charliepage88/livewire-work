<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\TaskPhoto;

use Storage;

class ManageTaskPhotos extends Component
{
    use WithFileUploads;

    public $viewImageModal = null;

    /**
     * @var bool
     */
    public $canCreate = true;

    /**
     * @var Collection
     */
    public $photos;

    /**
     * @var string
     */
    public $newPhoto = null;

    /**
     * @var string
     */
    public $grouped_date;

    /**
     * @var mixed
     */
    public $is_deleting = null;

    /**
     * Delete Photo
     * 
     * @param int $photo_id
     * 
     * @return void
     */
    public function deletePhoto(int $photo_id)
    {
        if ($photo_id !== $this->is_deleting) {
            $this->is_deleting = $photo_id;
        } else {
            $this->is_deleting = null;
        }
    }

    /**
     * Unset Photo
     * 
     * @return void
     */
    public function unsetPhoto()
    {
        $this->newPhoto = null;
    }

    /**
     * Delete
     * Deletes the task photo
     * 
     * @return void
     */
    public function delete()
    {
        if (!$this->is_deleting) {
            abort(500, 'Empty photo ID when trying to delete :(');
        }

        // delete the task photo
        if (get_class($this->photos) === 'Illuminate\Database\Eloquent\Collection') {
            $is_collection = true;
            $photo = $this->photos->find($this->is_deleting);
        } else {
            $is_collection = false;
            $photo = TaskPhoto::find($this->is_deleting);
        }

        // delete s3 file
        try {
            Storage::delete($photo->photo);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        // delete mysql row
        $photo->delete();

        if ($is_collection) {
            $this->photos = $this->photos->fresh();
        } else {
            $this->photos = TaskPhoto::where('grouped_date', $this->grouped_date)->get();
        }

        // set flash message
        session()->flash('message', 'Photo successfully deleted.');

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
            'newPhoto' => 'required|image',
        ]);

        // save task photo
        $photo = new TaskPhoto;

        $photo->grouped_date = $this->grouped_date;
        $photo->user_id = auth()->user()->id;

        $photo->photo = $this->newPhoto->store('taskPhotos', 's3');

        $photo->save();

        // set flash message
        session()->flash('message', 'Photo successfully uploaded.');

        if (is_array($this->photos)) {
            $this->photos = collect([]);
        }

        $this->photos->push($photo);

        // clear out photo data
        $this->unsetPhoto();
    }

    /**
     * Render
     * 
     * @return View
     */
    public function render()
    {
        return view('livewire.manage-task-photos');
    }
}

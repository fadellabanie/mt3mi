<?php

namespace App\Http\Livewire\Dashboard\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Datatable extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $selectedId;
    public $onlyTrashed = false;

    public function confirm($id)
    {
        $this->authorize('Delete Tags');

        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        Tag::restaurant()->findOrFail($this->selectedId)->delete();
    }

    public function restore($id)
    {
        $row = Tag::whereId($id)->withTrashed()->first();
        $row->restore();
    }

    public function delete($id)
    {
        $row = Tag::whereId($id)->withTrashed()->first();
        $row->forceDelete();
        $row->products()->detach();

    }

    public function render()
    {
        return view('livewire.dashboard.tags.datatable', [
            'tags' => ($this->onlyTrashed) ?
            Tag::restaurant()->onlyTrashed()->paginate() :
            Tag::restaurant()->paginate()
        ]);
    }
}

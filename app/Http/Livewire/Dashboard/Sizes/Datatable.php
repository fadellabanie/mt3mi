<?php

namespace App\Http\Livewire\Dashboard\Sizes;

use App\Models\ProductSize;
use Livewire\Component;
use Livewire\WithPagination;


class Datatable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedId;
    public $cost_type;
    public $onlyTrashed = false;

  
    public function confirm($id)
    {
        $this->emit('openDeleteModal');
        $this->selectedId = $id;
    }

    public function destroy()
    {
        ProductSize::findOrFail($this->selectedId)->restaurant()->delete();
    }

    public function restore($id)
    {
        $row = ProductSize::restaurant()->whereId($id)->withTrashed()->first();
        $row->restore();
    }
    public function delete($id)
    {
        $row = ProductSize::restaurant()->whereId($id)->withTrashed()->first();
        $row->forceDelete();
    }

    public function render()
    {


            return view('livewire.dashboard.sizes.datatable', [
                'sizes' => ProductSize::restaurant()->onlyTrashed()->paginate()
            ]);
        
       
    }
}

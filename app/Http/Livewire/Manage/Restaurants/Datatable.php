<?php

namespace App\Http\Livewire\Manage\Restaurants;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;

class Datatable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.manage.restaurants.datatable', [
            'restaurants' => Restaurant::paginate()
        ]);
    }
}

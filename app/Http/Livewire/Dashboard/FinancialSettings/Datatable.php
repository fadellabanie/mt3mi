<?php

namespace App\Http\Livewire\Dashboard\FinancialSettings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FinancialSetting;

class Datatable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.dashboard.financial-settings.datatable', [
            'financialSettings' => FinancialSetting::restaurant()->paginate()
        ])->layout('layouts.admin');
    }
}

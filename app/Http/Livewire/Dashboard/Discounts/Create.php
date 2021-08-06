<?php

namespace App\Http\Livewire\Dashboard\Discounts;

use Livewire\Component;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Support\ApplyType;
use App\Support\ActivationType;

class Create extends Component
{
    public $name_ar;
    public $name_en;
    public $type = 'Value';
    public $value;
    public $applies_to = [];
    public $activate_for = [];
    public $is_taxable = false;
    public $start_date;
    public $discountCategories = [];
    public $discountProducts = [];

    protected $rules = [
        'name_ar' => 'required|min:3|max:25',
        'name_en' => 'required|min:3|max:25',
        'type' => 'required',
        'value' => 'required|numeric',
        'applies_to' => "required|array",
        'activate_for' => 'required|array',
        'is_taxable' => 'boolean',
        'start_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;

        $discount = Discount::create($validatedData);

        $discount->categories()->attach($this->discountCategories);

        $discount->products()->attach($this->discountProducts);

        $this->reset();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.dashboard.discounts.create', [
            'applyTypes' => ApplyType::types(),
            'activationTypes' => ActivationType::types(),
            'categories' => Category::restaurant()->active()->get(),
            'products' => Product::restaurant()->isCombo(false)->active()->get(),
        ]);
    }
}

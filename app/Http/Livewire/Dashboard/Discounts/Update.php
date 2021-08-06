<?php

namespace App\Http\Livewire\Dashboard\Discounts;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Discount;
use App\Support\ApplyType;
use App\Support\ActivationType;

class Update extends Component
{
    public $discount;
    public $discountCategories;
    public $discountProducts;

    protected $rules = [
        'discount.name_ar' => 'required|min:3|max:25',
        'discount.name_en' => 'required|min:3|max:25',
        'discount.type' => 'required',
        'discount.value' => 'required|numeric',
        'discount.applies_to' => "required|array",
        'discount.activate_for' => 'required|array',
        'discount.is_taxable' => 'boolean',
        'discount.start_date' => 'sometimes|date|date_format:Y-m-d|after_or_equal:today',
    ];

    public function submit()
    {
        $this->validate();

        $this->discount->save();

        $this->discount->categories()->sync($this->discountCategories);

        $this->discount->products()->sync($this->discountProducts);

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount(Discount $discount)
    {
        $this->discount = $discount;
        $this->discountCategories = $discount->categories()->pluck('category_id')->all();
        $this->discountProducts = $discount->products()->pluck('product_id')->all();
    }

    public function render()
    {
        return view('livewire.dashboard.discounts.update', [
            'applyTypes' => ApplyType::types(),
            'activationTypes' => ActivationType::types(),
            'categories' => Category::restaurant()->active()->get(),
            'products' => Product::restaurant()->isCombo(false)->active()->get(),
        ]);
    }
}

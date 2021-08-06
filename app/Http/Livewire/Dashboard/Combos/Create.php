<?php

namespace App\Http\Livewire\Dashboard\Combos;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Product;
use App\Models\TimedEvent;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name_ar;
    public $name_en;
    public $description_ar;
    public $description_en;
    public $category_id;
    public $pricing_type = 'pre_set';
    public $selling_type = 'unit';
    public $sku;
    public $barcode;
    public $preparation_time;
    public $is_taxable = 1;
    public $image;
    public $productTags = [];
    public $productTimedEvents = [];
    public $sizes;
    public $productModifiers;

    protected $listeners = ['sizeUpdated', 'modifierUpdated'];

    protected $rules = [
        'name_ar' => 'required|string|min:3|max:25',
        'name_en' => 'required|string|min:3|max:25',
        'description_ar' => 'nullable|string|max:500',
        'description_en' => 'nullable|string|max:500',
        'category_id' => 'required|exists:categories,id',
        'pricing_type' => 'required',
        'selling_type' => 'required',
        'sku' => 'nullable|string|min:3|max:25',
        'barcode' => 'nullable|string|min:3|max:25',
        'preparation_time' => 'nullable|numeric',
        'is_taxable' => 'boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
    ];

    public function sizeUpdated($sizes)
    {
        $this->sizes = $sizes;
    }

    public function modifierUpdated($productModifiers)
    {
        $this->productModifiers = $productModifiers;
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $validatedData['restaurant_id'] = auth()->user()->restaurant_id;
        $validatedData['image'] = ($this->image) ? $this->image->store('products', 'public') : '';
        $validatedData['is_combo'] = 1;

        if (is_null($this->sizes)) {
            $this->dispatchBrowserEvent('swal', [
                'title' => __('A product must have at least 1 size.'),
                'icon' => 'error',
                'showConfirmButton' => true
            ]);

            return;
        }

        $product = Product::create($validatedData);

        $product->tags()->attach($this->productTags);

        $product->timedEvents()->attach($this->productTimedEvents);

        foreach ($this->sizes as $size) {
            $product->productSizes()->create([
                'name_ar' => $size['name_ar'],
                'name_en' => $size['name_en'],
                'barcode' => $size['barcode'],
                'sku' => $size['sku'],
                'calories' => $size['calories'],
                'cost_type' => $size['cost_type'],
                'cost' => $size['cost'],
                'price' => $size['price']
            ]);
        }

        if (! is_null($this->productModifiers)) {
            foreach ($this->productModifiers as $productModifier) {
                $product->productModifiers()->create([
                    'modifier_id' => $productModifier['id'],
                    'minimum_options' => $productModifier['minimum_options'],
                    'maximum_options' => $productModifier['maximum_options']
                ]);
            }
        }

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.combos.index');
    }

    public function render()
    {
        return view('livewire.dashboard.combos.create', [
            'categories' => Category::active()->restaurant()->get(),
            'tags' => Tag::active()->restaurant()->get(),
            'timedEvents' => TimedEvent::restaurant()->get()
        ]);
    }
}

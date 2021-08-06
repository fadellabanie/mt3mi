<?php

namespace App\Http\Livewire\Dashboard\Products;

use App\Models\Tag;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\TimedEvent;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $product;
    public $productTags;
    public $productTimedEvents;
    public $upload;

    protected $rules = [
        'product.name_ar' => 'required|string|min:3|max:25',
        'product.name_en' => 'required|string|min:3|max:25',
        'product.description_ar' => 'nullable|string|max:500',
        'product.description_en' => 'nullable|string|max:500',
        'product.category_id' => 'required|exists:categories,id',
        'product.pricing_type' => 'required',
        'product.selling_type' => 'required',
        'product.sku' => 'nullable|string|min:3|max:25',
        'product.barcode' => 'nullable|string|min:3|max:25',
        'product.preparation_time' => 'nullable|numeric',
        'product.is_taxable' => 'boolean',
        'product.image' => 'nullable'
    ];

    public function updatedUpload()
    {
        $this->validate([
            'upload' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function submit()
    {
        $this->validate();

        $this->product->save();

        if ($this->upload) {
            $this->product->update([
                'image' => $this->upload->store('products', 'public')
            ]);
        }

        $this->product->tags()->sync($this->productTags);

        $this->product->timedEvents()->sync($this->productTimedEvents);

        session()->flash('alert', __('Saved Successfully.'));

        return redirect()->route('dashboard.products.index');
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->productTags = $product->tags()->pluck('tag_id')->all();
        $this->productTimedEvents = $product->timedEvents()->pluck('timed_event_id')->all();
    }

    public function render()
    {
        return view('livewire.dashboard.products.update', [
            'categories' => Category::restaurant()->active()->get(),
            'tags' => Tag::restaurant()->get(),
            'timedEvents' => TimedEvent::restaurant()->get()
        ]);
    }
}

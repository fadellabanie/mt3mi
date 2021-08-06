<?php

namespace App\Http\Livewire\Dashboard\Settings;

use App\Models\AppSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateAppSettings extends Component
{
    use WithFileUploads;

    public AppSetting $appSetting;
    public $waiter_app_background_upload;
    public $cashier_app_background_upload;
    public $customer_app_background_upload;
    public $receipt_logo_upload;

    protected $rules = [
        'appSetting.order_type_id' => 'nullable|exists:order_types,id',
        'appSetting.logout_inactive_after' => 'nullable|integer',
        'appSetting.reset_order_number_after' => 'nullable|integer',
        'appSetting.void_require_customer_info' => 'boolean',
        'appSetting.discount_require_customer_info' => 'boolean' ,
        'appSetting.run_in_submode' => 'boolean',
        'appSetting.receipt_language' => 'required|string',
        'appSetting.receipt_header' => 'nullable|string',
        'appSetting.receipt_footer' => 'nullable|string',
    ];

    public function updatedWaiterAppBackgroundUpload()
    {
        $this->validate([
            'waiter_app_background_upload' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function updatedCashierAppBackgroundUpload()
    {
        $this->validate([
            'cashier_app_background_upload' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function updatedCustomerAppBackgroundUpload()
    {
        $this->validate([
            'customer_app_background_upload' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function updatedReceiptLogoUpload()
    {
        $this->validate([
            'receipt_logo_upload' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    public function submit()
    {
        $this->validate();

        if ($this->waiter_app_background_upload) {
            $this->appSetting->waiter_app_background = $this->waiter_app_background_upload->store('app_settings', 'public');
        }

        if ($this->cashier_app_background_upload) {
            $this->appSetting->cashier_app_background = $this->cashier_app_background_upload->store('app_settings', 'public');
        }

        if ($this->customer_app_background_upload) {
            $this->appSetting->customer_app_background = $this->customer_app_background_upload->store('app_settings', 'public');
        }

        if ($this->receipt_logo_upload) {
            $this->appSetting->receipt_logo = $this->receipt_logo_upload->store('app_settings', 'public');
        }

        $this->appSetting->save();

        session()->flash('alert', __('Saved Successfully.'));
    }

    public function mount()
    {
        $this->appSetting = AppSetting::firstOrCreate([
            'restaurant_id' => auth()->user()->restaurant_id,
            'order_type_id' => 1
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.settings.update-app-settings');
    }
}

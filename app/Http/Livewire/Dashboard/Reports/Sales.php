<?php

namespace App\Http\Livewire\Dashboard\Reports;

use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\OrderType;
use App\Models\PaymentMethod;
use App\Models\ModifierOption;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reports\SalesByCoupon;
use App\Exports\Reports\SalesByCashier;
use App\Exports\Reports\SalesByCategory;
use App\Exports\Reports\SalesByCombo;
use App\Exports\Reports\SalesByModifier;
use App\Exports\Reports\SalesByOrderType;
use App\Exports\Reports\SalesByPaymentMethod;

class Sales extends Component
{
    public $cashier = 'all';
    public $payment_method = 'all';
    public $coupon = 'all';
    public $category = 'all';
    public $product = 'all';
    public $modifier = 'all';
    public $combo = 'all';
    public $orderType = 'all';

    public function exportByCashier()
    {
        $data = Order::restaurant()->when($this->cashier != 'all', function ($query) {
            return $query->where('cashier_id', '=', $this->cashier);
        })->with(['cashier'])->get();

        return Excel::download(new SalesByCashier($data), 'sales_by_cashier.xlsx');
    }

    public function exportByPaymentMethod()
    {
        $data = Order::restaurant()->when($this->payment_method != 'all', function ($query) {
            return $query->where('payment_method_id', '=', $this->payment_method);
        })->with(['paymentMethod'])->get();

        return Excel::download(new SalesByPaymentMethod($data), 'sales_by_payment_method.xlsx');
    }

    public function exportByCoupon()
    {
        $data = Order::restaurant()->when($this->coupon != 'all', function ($query) {
            return $query->where('coupon_id', '=', $this->coupon);
        })->whereNotNull('coupon_id')->with(['coupon'])->get();

        return Excel::download(new SalesByCoupon($data), 'sales_by_coupon.xlsx');
    }

    public function exportByCategory()
    {
        $data = Order::restaurant()->when($this->category != 'all', function ($query) {
            $query->whereHas('orderProducts', function ($query) {
                $query->whereHas('productSize', function ($query) {
                    $query->whereHas('product', function ($query) {
                        $query->whereHas('category', function ($query) {
                            $query->where('id', $this->category);
                        });
                    });
                });
            });
        })->whereHas('orderProducts', function ($query) {
            $query->whereHas('productSize', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->whereHas('category');
                });
            });
        })->with(['orderProducts.productSize.product.category'])
        ->get();

        return Excel::download(new SalesByCategory($data), 'sales_by_category.xlsx');
    }

    public function exportByProduct()
    {
        $data = Order::restaurant()->when($this->product != 'all', function ($query) {
            $query->whereHas('orderProducts', function ($query) {
                $query->whereHas('productSize', function ($query) {
                    $query->whereHas('product', function ($query) {
                        $query->where('id', $this->product);
                    });
                });
            });
        })->whereHas('orderProducts', function ($query) {
            $query->whereHas('productSize', function ($query) {
                $query->whereHas('product');
            });
        })->with(['orderProducts.productSize.product'])
        ->get();

        return Excel::download(new SalesByCategory($data), 'sales_by_product.xlsx');
    }

    public function exportByModifier()
    {
        $data = Order::restaurant()->when($this->modifier != 'all', function ($query) {
            $query->whereHas('orderProducts', function ($query) {
                $query->whereHas('orderProductModifiers', function ($query) {
                    $query->whereHas('modifierOption', function ($query) {
                        $query->where('id', $this->modifier);
                    });
                });
            });
        })->whereHas('orderProducts', function ($query) {
            $query->whereHas('orderProductModifiers', function ($query) {
                $query->whereHas('modifierOption');
            });
        })->with(['orderProducts.orderProductModifiers.modifierOption'])
            ->get();

        return Excel::download(new SalesByModifier($data), 'sales_by_modifier.xlsx');
    }

    public function exportByCombo()
    {
        $data = Order::restaurant()->when($this->combo != 'all', function ($query) {
            $query->whereHas('orderProducts', function ($query) {
                $query->whereHas('productSize', function ($query) {
                    $query->whereHas('product', function ($query) {
                        $query->isCombo()->where('id', $this->combo);
                    });
                });
            });
        })->whereHas('orderProducts', function ($query) {
            $query->whereHas('productSize', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->isCombo();
                });
            });
        })->with(['orderProducts.productSize.product'])
            ->get();

        return Excel::download(new SalesByCombo($data), 'sales_by_combo.xlsx');
    }

    public function exportByOrderType()
    {
        $data = Order::restaurant()->when($this->orderType != 'all', function ($query) {
            return $query->where('order_type_id', '=', $this->orderType);
        })->whereNotNull('order_type_id')->with(['orderType'])->get();

        return Excel::download(new SalesByOrderType($data), 'sales_by_order_type.xlsx');
    }

    public function render()
    {
        return view('livewire.dashboard.reports.sales', [
            'users' => User::restaurant()->where('type', '=', 'app user')->get(),
            'paymentMethods' => PaymentMethod::restaurant()->get(),
            'coupons' => Coupon::restaurant()->get(),
            'categories' => Category::restaurant()->get(),
            'products' => Product::restaurant()->get(),
            'modifiers' => ModifierOption::whereHas('modifier', function ($query) {
                $query->restaurant();
            })->get(),
            'combos' => Product::restaurant()->isCombo()->get(),
            'orderTypes' => OrderType::get(),
        ])->layout('layouts.admin');
    }
}

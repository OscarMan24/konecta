<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use App\Models\Products;
use App\Models\Categoria;
use App\Models\SaleProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopLivewire extends Component
{

    public $quantity = 1, $search;

    public function render()
    {
        return view('livewire.shop-livewire');
    }

    public function save()
    {
        $this->validate([
            'quantity' => 'required|integer|min:1|max:999999',
            'search' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $prodct = Products::where([
                ['reference',  $this->search], ['status', 1], ['deleted', 0]
            ])->first();
            if (!empty($prodct)) {
                if ($prodct->stock > 0 && $prodct->stock >= $this->quantity) {
                    $this->dispatchBrowserEvent('success');
                    $sale = new SaleProduct();
                    $sale->user_id = Auth::user()->id;
                    $sale->product_id = $prodct->id;
                    $sale->quantity = $this->quantity;
                    $sale->save();

                    $prodct->stock = $prodct->stock - $this->quantity;
                    $prodct->update();
                    DB::commit();
                } else {
                    $this->dispatchBrowserEvent('errores', ['error' => __('There are not enough products')]);
                }
            } else {
                $this->dispatchBrowserEvent('errores', ['error' => __('Product not found')]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function sum()
    {
        $this->quantity++;
    }

    public function rest()
    {
        if ($this->quantity >= 1) {
            $this->quantity--;
        }
    }

    // public function getProductosProperty()
    // {
    //     return Products::where([
    //         ['status', 1], ['deleted', 0]
    //     ])->get();
    // }
}

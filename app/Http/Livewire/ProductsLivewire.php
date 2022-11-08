<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use Exception;
use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductsLivewire extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['borrado'];
    public $search = '', $search_status = '', $search_category = '';
    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'search_status' => ['except' => '', 'as' => 'status'],
        'search_category' => ['except' => '', 'as' => 'category'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];
    public $product_id, $readytoload = false;
    public $image, $current_image, $product_name, $price = 1, $type_wheight, $weight = 0, $stock = 1, $category_id;

    public function render()
    {
        return view('livewire.products-livewire');
    }

    public function loadData()
    {
        $this->readytoload = true;
    }

    public function store()
    {
        abort_if(Gate::denies('productos.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'product_name' => 'required|string|max:120|min:2',
            'image' =>  'nullable|image|max:5048|dimensions:width=512,height=512',
            'price' => 'required|integer|min:1|max:999999',
            "type_wheight" => 'required',
            "weight" => 'required|numeric',
            "stock" => 'required|integer|min:1',
            'category_id' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $product = new Products();
            $product->categoria_id = $this->category_id;
            $product->reference = Str::upper(Str::random(8));
            $product->product_name = $this->product_name;
            if ($this->image) {
                $imgname2 = Str::slug(Str::limit($this->product_name, 8, '')) . '-' . Str::random(4);
                $imageame2 = $imgname2 . '.' . $this->image->extension();
                $this->image->storeAs('products', $imageame2, 'public');
                $product->image = $imageame2;
            } else {
                $product->image = 'default_product.png';
            }
            $product->price = $this->price;
            $product->type_weight = $this->type_wheight;
            $product->weight = $this->weight;
            $product->stock = $this->stock;
            $product->status = 1;
            $product->deleted = 0;
            $product->save();
            $this->dispatchBrowserEvent('storeItem');
            $this->clean();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('productos.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->product_id = $id;
        if ($this->Productoo != '') {
            $this->current_image = $this->Productoo->image;
            $this->product_name = $this->Productoo->product_name;
            $this->price = $this->Productoo->price;
            $this->type_wheight = $this->Productoo->type_weight;
            $this->weight = $this->Productoo->weight;
            $this->category_id = $this->Productoo->categoria_id;
            $this->stock = $this->Productoo->stock;
            $this->dispatchBrowserEvent('openEdit');
        } else {
            $this->dispatchBrowserEvent('errores', ['error' => __('An error has occurred, contact support')]);
        }
    }

    public function editItem()
    {
        abort_if(Gate::denies('productos.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'product_name' => 'required|string|max:120|min:2',
            'image' =>  'nullable|image|max:5048|dimensions:width=512,height=512',
            'price' => 'required|integer|min:1|max:999999',
            "type_wheight" => 'required',
            "weight" => 'required|numeric',
            "stock" => 'required|integer|min:1',
            'category_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $this->Productoo->categoria_id = $this->category_id;
            $this->Productoo->product_name = $this->product_name;
            if ($this->image) {
                $imgname2 = Str::slug(Str::limit($this->product_name, 8, '')) . '-' . Str::random(4);
                $imageame2 = $imgname2 . '.' . $this->image->extension();
                $this->image->storeAs('products', $imageame2, 'public');
                $this->Productoo->image = $imageame2;
            }
            $this->Productoo->price = $this->price;
            $this->Productoo->type_weight = $this->type_wheight;
            $this->Productoo->weight = $this->weight;
            $this->Productoo->stock = $this->stock;
            $this->Productoo->update();
            $this->dispatchBrowserEvent('updatItem');
            $this->clean();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function changestatus($id)
    {
        abort_if(Gate::denies('productos.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->product_id = $id;
        if ($this->Productoo != '') {
            if ($this->Productoo->status == 1) {
                $this->Productoo->Status = 0;
            } else {
                $this->Productoo->status = 1;
            }
            $this->Productoo->update();
            $this->dispatchBrowserEvent('statuschanged');
        } else {
            $this->dispatchBrowserEvent('errores', ['error' => __('An error has occurred, contact support')]);
        }
    }

    public function borrar($id)
    {
        abort_if(Gate::denies('productos.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->product_id = $id;
        $this->dispatchBrowserEvent('borrar');
    }

    public function borrado()
    {
        abort_if(Gate::denies('productos.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->Productoo != '') {
            $this->Productoo->deleted = 1;
            $this->Productoo->stock = 0;
            $this->Productoo->update();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchCategory()
    {
        $this->resetPage();
    }

    public function clean()
    {
        $this->resetExcept(['search', 'search_status', 'readytoload']);
    }

    public function getProductosProperty()
    {
        return Products::with('categoria:id,name')->where([
            ['reference', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
        ])->orWhere([
            ['product_name', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
        ])->paginate(12);
    }

    public function getProductooProperty()
    {
        return Products::where([
            ['id', $this->product_id], ['deleted', 0]
        ])->first();
    }

    public function getCategoriasProperty()
    {
        return Categoria::where([
            ['status', 1], ['deleted', 0]
        ])->get();
    }
}

<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CategoryLivewire extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['borrado'];
    public $search = '', $search_status = '';
    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'search_status' => ['except' => '', 'as' => 'status'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];
    public $name_category;
    public $category_id;
    public $readytoload = false;


    public function render()
    {
        return view('livewire.category-livewire');
    }

    public function loadData()
    {
        $this->readytoload = true;
    }

    public function store()
    {
        abort_if(Gate::denies('categoria.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_category' => 'required|string|max:120|min:2|unique:categorias,name',
        ]);

        DB::beginTransaction();
        try {
            $categoria = new Categoria();
            $categoria->identifier = Str::upper(Str::random(8));
            $categoria->name = $this->name_category;
            $categoria->status = 1;
            $categoria->deleted = 0;
            $categoria->save();
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
        abort_if(Gate::denies('categoria.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->category_id = $id;
        if ($this->Categoria != '') {
            $this->name_category = $this->Categoria->name;
            $this->dispatchBrowserEvent('openEdit');
        } else {
            $this->dispatchBrowserEvent('errores', ['error' => __('An error has occurred, contact support')]);
        }
    }

    public function editItem()
    {
        abort_if(Gate::denies('categoria.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_category' =>  ['required', 'string', Rule::unique('categorias', 'name')->ignore($this->category_id)],
        ]);

        DB::beginTransaction();
        try {
            $this->Categoria->name = $this->name_category;
            $this->Categoria->update();
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
        abort_if(Gate::denies('categoria.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->category_id = $id;
        if ($this->Categoria != '') {
            if ($this->Categoria->status == 1) {
                $this->Categoria->Status = 0;
            } else {
                $this->Categoria->status = 1;
            }
            $this->Categoria->update();
            $this->dispatchBrowserEvent('statuschanged');
        }
    }

    public function borrar($id)
    {
        abort_if(Gate::denies('categoria.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->category_id = $id;
        $this->dispatchBrowserEvent('borrar');
    }

    public function borrado()
    {
        abort_if(Gate::denies('categoria.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->Categoria != '') {
            $this->Categoria->deleted = 1;
            $this->Categoria->update();
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

    public function clean()
    {
        $this->resetExcept(['search', 'search_status', 'readytoload']);
    }

    public function getCategoriasProperty()
    {
        return Categoria::where([
            ['identifier', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
        ])->orWhere([
            ['name', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
        ])->paginate(12);
    }

    public function getCategoriaProperty()
    {
        return Categoria::where([
            ['id', $this->category_id], ['deleted', 0]
        ])->first();
    }
}

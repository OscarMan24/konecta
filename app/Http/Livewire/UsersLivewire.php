<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\User;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsersLivewire extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['borrado'];
    public $search = '', $search_status = '', $search_rol = '';
    public $name_user, $email_user, $image, $image_current, $password_user,  $roles_user = [];
    public $user_id;
    public $readytoload = false;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'search_status' => ['except' => '', 'as' => 'status'],
        'search_rol' => ['except' => '', 'as' => 'rol'],
        'page' => ['except' => 1, 'as' => 'p'],

    ];

    public function render()
    {
        return view('livewire.users-livewire');
    }

    public function loadData()
    {
        $this->readytoload = true;
    }

    public function store()
    {
        abort_if(Gate::denies('users.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_user' => 'required|min:2|max:120',
            'email_user' => 'nullable|email|unique:users,email',
            'image' => 'nullable|image|max:5048|dimensions:width=1080,height=1080',
            'password_user' => 'required|min:3|max:120',
            'roles_user' => 'required|array|min:1'
        ]);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $this->name_user;
            $user->email = $this->email_user;
            $user->password = Hash::make($this->password_user);
            if ($this->image) {
                $imgname2 = Str::slug(Str::limit($this->name_user, 6, '')) . '-' . Str::random(4);
                $imageame2 = $imgname2 . '.' . $this->image->extension();
                $this->image->storeAs('users', $imageame2, 'public');
                $user->image = $imageame2;
            } else {
                $user->image = 'defaultuser.png';
            }
            $user->status = 1;
            $user->deleted = 0;
            $user->save();
            $user->assignRole($this->roles_user);

            DB::commit();

            $this->dispatchBrowserEvent('storeuser');
            $this->clean();
            $this->reset('roles_user');
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('users.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user_id = $id;
        if ($this->Userr != '') {
            $this->reset('roles_user');
            $this->name_user = $this->Userr->name;
            $this->email_user = $this->Userr->email;
            $this->image_current = $this->Userr->image;
            foreach ($this->Userr->getRoleNames() as $r) {
                $this->addrol($r);
            }
            $this->dispatchBrowserEvent('openEdit');
        } else {
            $this->dispatchBrowserEvent('errores', ['error' => __('An error has occurred, contact support')]);
        }
    }

    public function editUser()
    {
        abort_if(Gate::denies('users.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_user' => 'required|min:2|max:120',
            'email_user' =>  ['nullable', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user_id)],
            'image' => 'nullable|image|max:5048',
            'password_user' => 'nullable|min:3|max:120',
            'roles_user' => 'required|array|min:1'
        ]);

        DB::beginTransaction();
        try {
            $this->Userr->name = $this->name_user;
            $this->Userr->email = $this->email_user;
            if ($this->password_user != '') {
                $this->Userr->password = Hash::make($this->password_user);
            }
            if ($this->image) {
                $imgname2 = Str::slug(Str::limit($this->name_user, 6, '')) . '-' . Str::random(4);
                $imageName2 = $imgname2 . '.' . $this->image->extension();
                $this->image->storeAs('users', $imageName2, 'public');
                $this->Userr->image = $imageName2;
            }
            $this->Userr->update();
            $this->Userr->syncRoles($this->roles_user);


            DB::commit();
            $this->dispatchBrowserEvent('updateusser');
            $this->clean();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function addrol($id)
    {
        /* Validates if the role exists in the array, if it exists it eliminates it otherwise it adds it */
        $r = array_search($id, array_column($this->roles_user, 'id'));

        if ($r !== false) {
            unset($this->roles_user[$r]);
        } else {
            $temporal = array(
                'id' => $id
            );
            array_push($this->roles_user, $temporal);
        }
    }

    public function changestatus($id)
    {
        abort_if(Gate::denies('users.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user_id = $id;
        if ($this->Userr != '') {
            if ($this->Userr->status == 1) {
                $this->Userr->Status = 0;
            } else {
                $this->Userr->status = 1;
            }
            $this->Userr->update();
            $this->dispatchBrowserEvent('statuschanged');
        }
    }

    public function borrar($id)
    {
        abort_if(Gate::denies('users.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user_id = $id;
        $this->dispatchBrowserEvent('borrar');
    }

    public function borrado()
    {
        abort_if(Gate::denies('users.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->Userr != '') {
            $this->Userr->email = base64_encode($this->Userr->email);
            $this->Userr->status = 2;
            $this->Userr->deleted = 1;
            $this->Userr->update();
        }
    }

    public function clean()
    {
        $this->resetExcept(['search', 'search_status', 'search_rol', 'readytoload']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchRol()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {

        if ($this->search_rol != '') {
            $user = User::role($this->search_rol)
                ->where([
                    ['name', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
                ])->paginate(12);
        } else {
            $user = User::where([
                ['name', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
            ])->orWhere([
                ['email', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
            ])->orWhere([
                ['id', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
            ])->paginate(12);
        }
        return $user;
    }

    public function getUserrProperty()
    {
        return User::where('id', $this->user_id)->first();
    }


    public function getRolesProperty()
    {
        return Role::all()->pluck('name');
    }
}

<div wire:init="loadData">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('All users') }}
                        @can('users.store')
                            <button data-bs-toggle="modal" data-bs-target="#createuser" class="btn btn-primary ml-2"
                                type="button" wire:click="clean()"><i class="fas fa-plus"></i></button>
                        @endcan
                    </h5>
                    <div class="row col-12 mb-4">
                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Search user') }}</span>
                            <input type="search" class="form-control @error('search') is-invalid @enderror"
                                placeholder="{{ __('Search user by') . ' id, name, last name' }}" wire:model="search">
                            @error('search')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Search state') }}</span>
                            <select class="form-control @error('search_status') is-invalid @enderror"
                                wire:model="search_status">
                                <option value="" selected>{{ __('Select an option') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Disabled') }}</option>
                            </select>
                            @error('search_status')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>
                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Search rol') }}</span>
                            <select class="form-control @error('search_rol') is-invalid @enderror"
                                wire:model="search_rol">
                                <option value="" selected>{{ __('Select an option') }}</option>
                                @foreach ($this->Roles as $rol)
                                    <option value="{{ $rol }}">{{ $rol }}</option>
                                @endforeach

                            </select>
                            @error('search_rol')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Roles') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    @can(['users.edit', 'user.delete'])
                                        <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->Users as $user)
                                    <tr>
                                        <th scope="row">#{{ $user->id }}</th>
                                        <td>
                                            <img src="{{ asset('/storage/users/' . $user->image) }}" alt="img-user"
                                                style="max-width: 50px; border-radius:50%">
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->getRoleNames() as $rol)
                                                <span class="badge bg-info">{{ $rol }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($user->status == 1)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @elseif($user->status == 0)
                                                <span class="badge bg-secondary">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        @can(['users.edit', 'users.delete'])
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        wire:key="dropdownMenuButton-{{ $user->id }}"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('users.edit')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="edit({{ $user->id }})"> <i
                                                                        class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                                            </li>

                                                            <li><button class="dropdown-item"
                                                                    wire:click="changestatus({{ $user->id }})"> <i
                                                                        class="fas fa-eye{{ $user->status == 1 ? '-slash' : '' }} "></i>
                                                                    {{ $user->status == 1 ? __('Deactivate') : __('Activate') }}</button>
                                                            </li>
                                                        @endcan

                                                        @can('users.delete')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="borrar({{ $user->id }})"> <i
                                                                        class="fas fa-trash-alt"></i>
                                                                    {{ __('Deleted') }}</button></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        @endcan

                                    </tr>
                                @empty
                                    <tr>
                                        @can(['users.edit', 'user.delete'])
                                            <td colspan="6" class="text-center justify-content-center">
                                                ¡{{ __('No users available') }}!
                                            </td>
                                        @else
                                            <td colspan="5" class="text-center justify-content-center">
                                                ¡{{ __('No users available') }}!
                                            </td>
                                        @endcan

                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    @if (count($this->Users) > 0)
                        <div class="row text-center justify-content-center mt-2" style="max-width: 99%">
                            {{ $this->Users->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($readytoload)
        @include('panel.users.modal.create')
        @include('panel.users.modal.edit')
    @endif


    <script>
        window.addEventListener('errores', event => {
            Swal.fire(
                '¡Error!',
                event.detail.error,
                'error'
            )
        })
        window.addEventListener('storeuser', event => {
            $('#createuser').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been created successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })

        window.addEventListener('openEdit', event => {
            $('#editUserr').modal('show');
        })

        window.addEventListener('updateusser', event => {
            $('#editUserr').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been updated successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })
        window.addEventListener('borrar', event => {
            Swal.fire({
                icon: 'question',
                title: "¿Are you sure?",
                text: "This action cannot be returned",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('borrado')
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: '¡Processing! ',
                        text: 'Wait a moment, it will be available soon',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    })
                }
            });
        });
        window.addEventListener('statuschanged', event => {
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has changed state successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })
    </script>
</div>

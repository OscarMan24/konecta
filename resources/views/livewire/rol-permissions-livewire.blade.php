<div wire:init="loadDatos">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('All roles') }}
                        @can('roles.store')
                            <button data-bs-toggle="modal" data-bs-target="#createRol" class="btn btn-primary ml-2"
                                type="button" wire:click="clean()"><i class="fas fa-plus"></i></button>
                        @endcan
                    </h5>
                    <div class="row col-12 mb-4">
                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Search rol') }}</span>
                            <input type="search" class="form-control @error('search') is-invalid @enderror"
                                placeholder="{{ __('Find role by name') }}" wire:model="search">
                            @error('search')
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
                                    <th scope="col">{{ __('Permissions') }}</th>
                                    @can(['roles.edit', 'roles.delete'])
                                        <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->Roles as $rol)
                                    <tr>
                                        <th scope="row">#{{ $rol->id }}</th>
                                        <td>{{ $rol->name }}</td>
                                        <td>
                                            @foreach ($rol->getPermissionNames() as $permiso)
                                                <span class="badge bg-info p-2 mb-2">{{ $permiso }}</span>
                                            @endforeach
                                        </td>

                                        @can(['roles.edit', 'roles.delete'])
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        wire:key="dropdownd-{{ $rol->id }}" id="dropdownMenuButton"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('roles.edit')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="edit({{ $rol->id }})"> <i
                                                                        class="fas fa-edit"></i> {{ __('Editar') }}</button>
                                                            </li>
                                                        @endcan

                                                        @can('user.delete')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="borrar({{ $rol->id }})"> <i
                                                                        class="fas fa-trash-alt"></i>
                                                                    {{ __('Borrar') }}</button></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        @can(['roles.edit', 'roles.delete'])
                                            <td colspan="4" class="text-center justify-content-center">
                                                ¡{{ __('No roles available') }}!
                                            </td>
                                        @else
                                            <td colspan="3" class="text-center justify-content-center">
                                                ¡{{ __('No roles available') }}!
                                            </td>
                                        @endcan

                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- @if ($readytoload)    --}}
    @include('panel.roles.modal.create')
    @include('panel.roles.modal.edit')

    {{-- @endif --}}


    <script>
        window.addEventListener('errores', event => {
            Swal.fire(
                '¡Error!',
                event.detail.error,
                'error'
            )
        })
        window.addEventListener('sstoree', event => {
            $('#createRol').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Exito!',
                text: 'The item has been created successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })

        window.addEventListener('actualiizar', event => {
            $('#editRoles').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Exito!',
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

        window.addEventListener('edit2', event => {
            $('#editRoles').modal('show');

        })
    </script>
</div>

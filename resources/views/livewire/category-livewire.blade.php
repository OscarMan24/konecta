<div wire:init="loadData">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('All categories') }}
                        @can('categoria.store')
                            <button data-bs-toggle="modal" data-bs-target="#createCategories" class="btn btn-primary ml-2"
                                type="button" wire:click="clean()"><i class="fas fa-plus"></i></button>
                        @endcan
                    </h5>
                    <div class="row col-12 mb-4">
                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Search categories') }}</span>
                            <input type="search" class="form-control @error('search') is-invalid @enderror"
                                placeholder="{{ __('Search categories by') . ' id, name' }}" wire:model="search">
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
                                    <th scope="col">{{ __('Identifier') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    @can(['categoria.edit', 'categoria.delete'])
                                        <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->Categorias as $categoria)
                                    <tr>
                                        <th scope="row">#{{ $categoria->id }}</th>
                                        <td>{{ $categoria->identifier }}</td>
                                        <td>{{ $categoria->name }}</td>
                                        <td>
                                            @if ($categoria->status == 1)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @elseif($categoria->status == 0)
                                                <span class="badge bg-secondary">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        @can(['categoria.edit', 'categoria.delete'])
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        wire:key="dropdownMenuButton-{{ $categoria->id }}"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('categoria.edit')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="edit({{ $categoria->id }})"> <i
                                                                        class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                                            </li>

                                                            <li><button class="dropdown-item"
                                                                    wire:click="changestatus({{ $categoria->id }})"> <i
                                                                        class="fas fa-eye{{ $categoria->status == 1 ? '-slash' : '' }} "></i>
                                                                    {{ $categoria->status == 1 ? __('Deactivate') : __('Activate') }}</button>
                                                            </li>
                                                        @endcan

                                                        @can('categoria.delete')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="borrar({{ $categoria->id }})"> <i
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
                                        @can(['categoria.edit', 'categoria.delete'])
                                            <td colspan="5" class="text-center justify-content-center">
                                                ¡{{ __('No category available') }}!
                                            </td>
                                        @else
                                            <td colspan="4" class="text-center justify-content-center">
                                                ¡{{ __('No category available') }}!
                                            </td>
                                        @endcan
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (count($this->Categorias) > 0)
                        <div class="row text-center justify-content-center mt-2" style="max-width: 99%">
                            {{ $this->Categorias->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($readytoload)
        @include('panel.category.modal.create')
        @include('panel.category.modal.edit')
    @endif


    <script>
        window.addEventListener('errores', event => {
            Swal.fire(
                '¡Error!',
                event.detail.error,
                'error'
            )
        })

        window.addEventListener('storeItem', event => {
            $('#createCategories').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been created successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })

        window.addEventListener('openEdit', event => {
            $('#editCategoria').modal('show');
        })

        window.addEventListener('updatItem', event => {
            $('#editCategoria').modal('hide');
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

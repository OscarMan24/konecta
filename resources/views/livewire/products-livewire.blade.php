<div wire:init="loadData">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('All the products') }}
                        @can('productos.store')
                            <button data-bs-toggle="modal" data-bs-target="#createProducts" class="btn btn-primary ml-2"
                                type="button" wire:click="clean()"><i class="fas fa-plus"></i></button>
                        @endcan
                    </h5>
                    <div class="row col-12 mb-4">
                        <div class="col-lg-4 col-md-4 col-12 mb-2">
                            <span>{{ __('Search products') }}</span>
                            <input type="search" class="form-control @error('search') is-invalid @enderror"
                                placeholder="{{ __('Search products by') . ' reference, name' }}" wire:model="search">
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
                            <span>{{ __('Search category') }}</span>
                            <select class="form-control @error('search_category') is-invalid @enderror"
                                wire:model="search_category">
                                <option value="" selected>{{ __('Select an option') }}</option>
                                @foreach ($this->Categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('search_category')
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
                                    <th scope="col">{{ __('Reference') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Category') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Weight') }}</th>
                                    <th scope="col">{{ __('Stock') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    @can(['productos.edit', 'productos.delete'])
                                        <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->Productos as $producto)
                                    <tr>
                                        <th scope="row">#{{ $producto->id }}</th>
                                        <td>{{ $producto->reference }}</td>
                                        <td>
                                            <img src="{{ asset('/storage/products/' . $producto->image) }}"
                                                alt="img-product" style="max-width: 50px; border-radius:50%">
                                            {{ $producto->product_name }}
                                        </td>
                                        <td>{{ $producto->categoria->name }}</td>
                                        <td>{{ number_format($producto->price, 0, ',', '.') }}</td>
                                        <td>{{ Str::upper($producto->type_weight) . ' ' . $producto->weight }}</td>
                                        <td>
                                            @if ($producto->stock > 0)
                                                <span
                                                    class="badge bg-info">{{ number_format($producto->stock, 0, ',', '.') }}</span>
                                            @else
                                                <span
                                                    class="badge bg-danger">{{ number_format($producto->stock, 0, ',', '.') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($producto->status == 1)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @elseif($producto->status == 0)
                                                <span class="badge bg-secondary">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        @can(['productos.edit', 'productos.delete'])
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        wire:key="dropdownMenuButton-{{ $producto->id }}"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('productos.edit')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="edit({{ $producto->id }})"> <i
                                                                        class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                                            </li>

                                                            <li><button class="dropdown-item"
                                                                    wire:click="changestatus({{ $producto->id }})"> <i
                                                                        class="fas fa-eye{{ $producto->status == 1 ? '-slash' : '' }} "></i>
                                                                    {{ $producto->status == 1 ? __('Deactivate') : __('Activate') }}</button>
                                                            </li>
                                                        @endcan

                                                        @can('productos.delete')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="borrar({{ $producto->id }})"> <i
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
                                        @can(['productos.edit', 'productos.delete'])
                                            <td colspan="9" class="text-center justify-content-center">
                                                ¡{{ __('There are no products available') }}!
                                            </td>
                                        @else
                                            <td colspan="8" class="text-center justify-content-center">
                                                ¡{{ __('There are no products available') }}!
                                            </td>
                                        @endcan
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (count($this->Productos) > 0)
                        <div class="row text-center justify-content-center mt-2" style="max-width: 99%">
                            {{ $this->Productos->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($readytoload)
        @include('panel.products.modal.create')
        @include('panel.products.modal.edit')
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
            $('#createProducts').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been created successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })

        window.addEventListener('openEdit', event => {
            $('#editProducts').modal('show');
        })

        window.addEventListener('updatItem', event => {
            $('#editProducts').modal('hide');
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

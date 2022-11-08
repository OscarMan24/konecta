<div class="modal fade" id="editProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                        <span>{{ __('Name') }}</span>
                        <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                            placeholder="{{ __('Product name') }}" wire:model.defer="product_name"
                            wire:target="editItem" wire:loading.attr="disabled">
                        @error('product_name')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <span>{{ __('Category') }}</span>
                        <select class="form-control @error('category_id') is-invalid @enderror"
                            wire:model.defer="category_id">
                            <option value="" selected>{{ __('Select an option') }}</option>
                            @foreach ($this->Categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <span>{{ __('Price') }}</span>
                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                            wire:model.defer="price" wire:target="editItem" wire:loading.attr="disabled"
                            min="1">
                        @error('price')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <span>{{ __('Initial stock') }}</span>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                            wire:model.defer="stock" wire:target="editItem" wire:loading.attr="disabled"
                            min="1">
                        @error('stock')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <span>{{ __('Weight') }}</span>
                        <div class="d-flex">
                            <div class="col-md-4 col-6 mb-1">
                                <select class="form-control @error('type_wheight') is-invalid @enderror"
                                    wire:model.defer="type_wheight" wire:target="editItem" wire:loading.attr="disabled">
                                    <option value="ml">ml</option>
                                    <option value="l">l</option>
                                    <option value="mg">mg</option>
                                    <option value="g">g</option>
                                    <option value="kg">kg</option>
                                    <option value="oz">oz</option>
                                    <option value="lb">lb</option>
                                </select>
                                @error('type_wheight')
                                    <div class="invalid-feedback ">{{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-md-8 col-6 mb-1" style="margin-left: 5px">
                                <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                    wire:model.defer="weight" wire:target="editItem" wire:loading.attr="disabled"
                                    min="1">
                                @error('weight')
                                    <div class="invalid-feedback ">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <span>{{ __('Product image') }} (512 x 512px optional)</span>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" accept="image/*"
                            wire:model="image" wire:target="editItem" wire:loading.attr="disabled">
                        @error('image')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror

                        <div wire:loading.inline wire:target="image">
                            <div class="col-12 my-1 text-center justify-content-center row">
                                <div class="spinner-grow my-2" role="status">
                                </div>
                            </div>
                        </div>

                        @if ($this->image)
                            <div class="col-12 mb-3 mt-3 text-center justify-content-center row">
                                <span>{{ __('Image preview') }}</span>
                                <img class="img-fluid " src="{{ $image->temporaryUrl() }}"
                                    style="max-width: 300px; border-radius:1rem">
                            </div>
                        @endif

                        @if ($current_image)
                            <div class="col-12 mb-3 mt-3 text-center justify-content-center row">
                                <span>{{ __('Current image') }}</span>
                                <img class="img-fluid " src="{{ asset('storage/products/' . $current_image) }}"
                                    style="max-width: 300px; border-radius:1rem">
                            </div>
                        @endif
                    </div>
                    <div wire:loading wire:target="editItem">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                {{ __('Loading...') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:target="editItem" wire:loading.attr="disabled"
                    data-bs-dismiss="modal" wire:click="clean()">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" wire:target="editItem" wire:loading.attr="disabled"
                    wire:click="editItem()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

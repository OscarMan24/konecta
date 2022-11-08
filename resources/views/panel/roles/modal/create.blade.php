<div class="modal fade" id="createRol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create new rol') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12 mb-2">
                        <span class="mb-1">{{ __('Name') }}</span>
                        <input type="text" class="form-control @error('name_rol') is-invalid @enderror"
                            placeholder="{{ __('Role name') }}" wire:model.defer="name_rol" wire:target="store"
                            wire:loading.attr="disabled">
                        @error('name_rol')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <span class="mb-1">{{ __('Permissions') }} </span>
                        <div class="row">
                            @foreach ($this->Permisos as $permiso)
                                <div class="col-auto mb-2">
                                    <div class="custom-check" wire:key="custom-check-agg-{{ $permiso->id }}">
                                        <input class="form-check-input" type="checkbox" value="{{ $permiso->id }}"
                                            id="permiso-{{ $loop->iteration }}" wire:model.defer="permission_rol"
                                            wire:target="store" wire:loading.attr="disabled"
                                            wire:key="input-agg-{{ $permiso->id }}">
                                        <label class="form-check-label" for="permiso-{{ $loop->iteration }}">
                                            {{ $permiso->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div wire:loading wire:target="store">
                        <div class="progress col-12">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                {{ __('Loading...') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:target="store" wire:loading.attr="disabled"
                    data-bs-dismiss="modal" wire:click="clean()">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" wire:target="store" wire:loading.attr="disabled"
                    wire:click="store()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

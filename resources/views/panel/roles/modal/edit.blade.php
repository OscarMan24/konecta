<div class="modal fade" id="editRoles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit rol') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12 mb-2">
                        <span class="mb-1">{{ __('Name') }}</span>
                        <input type="text" class="form-control @error('name_rol') is-invalid @enderror"
                            placeholder="{{ __('Nombre del rol') }}" wire:model.defer="name_rol"
                            wire:target="actualizar" wire:loading.attr="disabled">
                        @error('name_rol')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <span class="mb-1">{{ __('Permissions') }} </span>
                        <div class="row">
                            @foreach ($this->Permisos as $permiso)
                                <div class="col-auto mb-2">
                                    <div class="custom-check" wire:key="custom-check-edit-{{ $permiso->id }}">
                                        <input class="form-check-input" type="checkbox" value="{{ $permiso->id }}"
                                            id="permiso2-{{ $loop->iteration }}" wire:model="permission_rol"
                                            wire:target="actualizar" wire:loading.attr="disabled"
                                            wire:key="input-edit-{{ $permiso->id }}">
                                        <label class="form-check-label" for="permiso2-{{ $loop->iteration }}">
                                            {{ $permiso->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div wire:loading wire:target="actualizar">
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
                <button type="button" class="btn btn-danger" wire:target="actualizar" wire:loading.attr="disabled"
                    data-bs-dismiss="modal" wire:click="limpiar()">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" wire:target="actualizar" wire:loading.attr="disabled"
                    wire:click="actualizar()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

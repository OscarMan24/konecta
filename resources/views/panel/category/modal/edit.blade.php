<div class="modal fade" id="editCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-12 mb-3">
                        <span>{{ __('Name') }}</span>
                        <input type="text" class="form-control @error('name_category') is-invalid @enderror"
                            placeholder="{{ __('Category name') }}" wire:model.defer="name_category"
                            wire:target="editItem" wire:loading.attr="disabled">
                        @error('name_category')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
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

<div class="modal fade" id="createuser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create new user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-12 mb-3">
                        <span>{{ __('Names') }}</span>
                        <input type="text" class="form-control @error('name_user') is-invalid @enderror"
                            placeholder="{{ __('User name') }}" wire:model.defer="name_user" wire:target="store"
                            wire:loading.attr="disabled">
                        @error('name_user')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-md-12 col-12 mb-3">
                        <span>{{ __('Email') }}</span>
                        <input type="email" class="form-control @error('email_user') is-invalid @enderror"
                            wire:model.defer="email_user" wire:target="store" wire:loading.attr="disabled"
                            placeholder="{{ __('User email') }}">
                        @error('email_user')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <span>{{ __('Password') }}</span>
                        <input type="text" class="form-control @error('password_user') is-invalid @enderror"
                            wire:model.defer="password_user" wire:target="store" wire:loading.attr="disabled"
                            placeholder="{{ __('Password') }}">
                        @error('password_user')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <span>{{ __('Roles') }} </span>
                        <div class="row">
                            @foreach ($this->Roles as $rol)
                                <div class="col-auto mb-3">
                                    <div class="custom-check" wire:key="rol-agg-{{ $loop->iteration }}">
                                        <input class="form-check-input" type="checkbox" value="true"
                                            id="rol{{ $loop->iteration }}"
                                            wire:key="rol-input-agg-{{ $loop->iteration }}"
                                            wire:click="addrol('{{ $rol }}')" wire:target="store"
                                            wire:loading.attr="disabled">
                                        <label class="form-check-label" for="rol{{ $loop->iteration }}">
                                            {{ $rol }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <span>{{ __('User image') }} (1080 x 1080px)</span>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" accept="image/*"
                            wire:model="image" wire:target="store" wire:loading.attr="disabled">
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
                    </div>
                    <div wire:loading wire:target="store">
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
                <button type="button" class="btn btn-danger" wire:target="store" wire:loading.attr="disabled"
                    data-bs-dismiss="modal" wire:click="clean()">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" wire:target="store" wire:loading.attr="disabled"
                    wire:click="store()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

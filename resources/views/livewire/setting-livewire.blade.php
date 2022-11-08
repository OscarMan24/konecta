<div wire:init="loadData">
    <div class="row">
        <div class="col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-cog"></i> &nbsp; {{ __('General') }}</h5>
                    <p class="card-description">
                        {{ __('General settings, such as the title, the logo of the site, etc.') }}.</p>
                    <div class="accordion accordion-flush" id="configgeneral">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne" wire:ignore.self>
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#setting-general" aria-expanded="false"
                                    aria-controls="setting-general">
                                    {{ __('Abrir') }}
                                </button>
                            </h2>
                            <div id="setting-general" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#configgeneral" wire:ignore.self>
                                <div class="accordion-body row">
                                    <div class=" col-lg-6 col-md-12 col-12 mb-3">
                                        <span>{{ __('Website name') }}</span>
                                        <input type="text"
                                            class="form-control @error('name_web') is-invalid @enderror"
                                            wire:model.defer="name_web" wire:target="storegeneral"
                                            wire:loading.attr="disabled">
                                        @error('name_web')
                                            <div class="invalid-feedback ">{{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class=" col-lg-6 col-md-12 col-12 mb-3">
                                        <span>{{ __('Logo') . ' ' . '(214 x 60px)' }}</span>
                                        <input type="file" accept="image/*"
                                            class="form-control @error('logo') is-invalid @enderror" wire:model="logo"
                                            wire:target="storegeneral" wire:loading.attr="disabled">
                                        @error('logo')
                                            <div class="invalid-feedback ">{{ $message }} </div>
                                        @enderror

                                        @if ($logo_actual)
                                            <div class="col-12 mb-3 mt-2 row text-center justify-content-center">
                                                <span>{{ __('Current logo') }}</span>
                                                <img class="img-fluid my-2"
                                                    src="{{ asset('/storage/public/' . $logo_actual) }}"
                                                    style="max-width: 150px; border-radius:1rem">
                                            </div>
                                        @endif

                                        <div class="col-12 mb-3 mt-2 row text-center justify-content-center"
                                            wire:loading wire:target="logo">
                                            <div class="spinner-grow" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>

                                        @if ($logo)
                                            <div class="col-12 mb-3 row mt-2 text-center justify-content-center">
                                                <span>{{ __('Preview logo') }}</span>
                                                <img class="img-fluid my-2" src="{{ $logo->temporaryUrl() }}"
                                                    style="max-width: 150px; border-radius:1rem">
                                            </div>
                                        @endif
                                    </div>

                                    <div class=" col-lg-6 col-md-12 col-12 mb-3">
                                        <span>{{ __('Logo oscuro') . ' ' . '(214 x 60px)' }}</span>
                                        <input type="file" accept="image/*"
                                            class="form-control @error('logo_oscuro') is-invalid @enderror"
                                            wire:model="logo_oscuro" wire:target="storegeneral"
                                            wire:loading.attr="disabled">
                                        @error('logo_oscuro')
                                            <div class="invalid-feedback ">{{ $message }} </div>
                                        @enderror

                                        @if ($logo_oscuro_actual)
                                            <div class="col-12 mb-3 mt-2 row text-center justify-content-center">
                                                <span> {{ __('Current dark logo') }}</span>
                                                <img class="img-fluid my-2"
                                                    src="{{ asset('/storage/public/' . $logo_oscuro_actual) }}"
                                                    style="max-width: 150px; border-radius:1rem">
                                            </div>
                                        @endif

                                        <div class="col-12 mb-3 mt-2 row text-center justify-content-center"
                                            wire:loading wire:target="logo_oscuro">
                                            <div class="spinner-grow" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>

                                        @if ($logo_oscuro)
                                            <div class="col-12 mb-3 mt-2 row text-center justify-content-center">
                                                <span>{{ __('Previous dark logo') }}</span>
                                                <img class="img-fluid my-2" src="{{ $logo_oscuro->temporaryUrl() }}"
                                                    style="max-width: 150px; border-radius:1rem">
                                            </div>
                                        @endif
                                    </div>

                                    <div class=" col-lg-6 col-md-12 col-12 mb-3">
                                        <span>{{ __('Icon') . ' (512 x 512px)' }}</span>
                                        <input type="file" accept=".png"
                                            class="form-control @error('icono') is-invalid @enderror" wire:model="icono"
                                            wire:target="storegeneral" wire:loading.attr="disabled">
                                        @error('icono')
                                            <div class="invalid-feedback ">{{ $message }} </div>
                                        @enderror
                                        @if ($icono_actual)
                                            <div class="col-12 mb-3 mt-2 row text-center justify-content-center">
                                                <span>{{ __('Current icon') }}</span>
                                                <img class="img-fluid my-2"
                                                    src="{{ asset('/storage/public/' . $icono_actual) }}"
                                                    style="max-width: 150px; border-radius:1rem">
                                            </div>
                                        @endif

                                        <div class="col-12 mb-3 mt-2 row text-center justify-content-center"
                                            wire:loading wire:target="icono">
                                            <div class="spinner-grow" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>

                                        @if ($icono)
                                            <div class="col-12 mb-3 mt-2 row text-center justify-content-center">
                                                <span>{{ __('Preview icon') }}</span>
                                                <img class="img-fluid my-2" src="{{ $icono->temporaryUrl() }}"
                                                    style="max-width: 150px; border-radius:1rem">
                                            </div>
                                        @endif
                                    </div>


                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary w-100" wire:target="storegeneral"
                                            wire:loading.attr="disabled" wire:click="storegeneral"> <i
                                                class="fas fa-save"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('errores', event => {
            Swal.fire(
                '¡Error!',
                event.detail.error,
                'error'
            )
        })
        window.addEventListener('saved', event => {
            Swal.fire({
                icon: 'success',
                title: '¡Success!',
                text: 'Configuration has been saved successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })
    </script>
</div>

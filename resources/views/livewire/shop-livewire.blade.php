<div>
    <style>
        input[type="number"] {
            -webkit-appearance: textfield;
            -moz-appearance: textfield;
            appearance: textfield;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        .quantity {

            color: #5b5b5b !important;
        }

        .number-input {
            border: 2px solid #ddd;
            display: inline-flex;
            border-radius: 10px;
        }

        .number-input,
        .number-input * {
            box-sizing: border-box;
        }

        .number-input button {
            outline: none;
            -webkit-appearance: none;
            background-color: transparent;
            border: none;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            cursor: pointer;
            margin: 0;
            position: relative;
        }

        .number-input button:before,
        .number-input button:after {
            display: inline-block;
            position: absolute;
            content: '';
            width: 1rem;
            height: 2px;
            background-color: #212121;
            transform: translate(-50%, -50%);
        }

        .number-input button.plus:after {
            transform: translate(-50%, -50%) rotate(90deg);
        }

        .number-input input[type=number] {
            font-family: sans-serif;
            max-width: 5rem;
            padding: .5rem;
            border: solid #ddd;
            border-width: 0 2px;
            font-size: 2rem;
            height: 3rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
    <div class="d-flex">
        <div class="col-md-8 col-12 mb-3">
            <span>{{ __('Search products') }}</span>
            <input type="search" class="form-control @error('search') is-invalid @enderror"
                placeholder="{{ __('Search products by') . ' reference, name' }}" wire:model="search" wire:target="save"
                wire:loading.attr="disabled" wire:keydown.enter="save">
            @error('search')
                <div class="invalid-feedback ">{{ $message }} </div>
            @enderror

        </div>
        <div class="col-md-4 col-12 mb-3 text-center justify-content-center">
            <span>{{ __('Quantity') }}</span> <br>
            <div class="number-input">
                <button wire:click="rest"></button>
                <input class="quantity @error('quantity') is-invalid @enderror" min="1" name="quantity"
                    wire:model.defer="quantity" type="number" wire:target="save" wire:loading.attr="disabled">
                <button wire:click="sum" class="plus"></button>
            </div>
            @error('quantity')
                <div class="invalid-feedback ">{{ $message }} </div>
            @enderror
        </div>
    </div>

    <div class="col-12 mb-3">
        <div wire:loading wire:target="save" class="w-100">
            <div class="progress my-3 w-100">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    {{ __('Loading...') }}
                </div>
            </div>
        </div>
        <button class="btn btn-primary btn-block w-100" wire:click="save" wire:target="save"
            wire:loading.attr="disabled"> <i class="fas fa-search"></i>
            {{ __('Search') }}</button>
    </div>

    <script>
        window.addEventListener('errores', event => {
            Swal.fire(
                '¡Error!',
                event.detail.error,
                'error'
            )
        })
        window.addEventListener('success', event => {
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'Successful sale',
                showConfirmButton: false,
                timer: 2000
            })
        })
    </script>
</div>

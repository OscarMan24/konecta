<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Shop konecta">
    <meta name="keywords" content="shop">
    <meta name="author" content="Oscar_Castellano">
    <title>{{ \App\Models\Setting::find(1)->app_name }} | {{ __('Shop') }}</title>
    <link href="{{ asset('/storage/public/' . \App\Models\Setting::find(1)->icono) }}" rel="icon" type="image/png">

    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body class="login-page">
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>{{ __('Loading') }}...</span>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-8">
                <div class="card login-box-container">
                    <div class="card-header">
                        <div class="col-12 mb-1 text-center justify-content-center">
                            <img src="{{ asset('/storage/public/' . \App\Models\Setting::find(1)->icono) }}"
                                alt="" style="max-width: 60px; border-radius:50%">
                        </div>
                    </div>

                    <div class="card-body">
                        @livewire('shop-livewire') </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="{{ asset('js/main.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/blazy.min.js') }}"></script>
    @livewireScripts
</body>

</html>

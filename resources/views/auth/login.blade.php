<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="control panel konecta">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="Oscar_Castellano">
    <title>{{ \App\Models\Setting::find(1)->app_name }} | {{ __('Control Panel') }}</title>
    <link href="{{ asset('/storage/public/' . \App\Models\Setting::find(1)->icono) }}" rel="icon" type="image/png">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @yield('css')
</head>

<body class="login-page">
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>{{ __('Loading') }}...</span>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div class="card login-box-container">
                    <div class="card-body">
                        <div class="authent-logo">
                            <img src="{{ asset('/storage/public/' . \App\Models\Setting::find(1)->logo) }}"
                                alt="">
                        </div>
                        <div class="authent-text">
                            <p>{{ __('Welcome to') . ' ' . \App\Models\Setting::find(1)->app_name }} </p>
                            <p>{{ __('Login in your account') }}.</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="{{ __('Username') }}"
                                        value="{{ old('email') }}" required>
                                    <label for="email">{{ __('Username') }}</label>
                                    @error('email')
                                        <div class="invalid-feedback ">{{ $message }} </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="{{ __('Your password') }}"
                                        value="{{ old('contraseña') }}" required>
                                    <label for="password">{{ __('Password') }}</label>
                                    @error('password')
                                        <div class="invalid-feedback ">{{ $message }} </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">{{ __('Remember') }}</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info m-b-xs">{{ __('Login') }}</button>
                            </div>
                        </form>
                    </div>
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

    @yield('jss')
</body>

</html>

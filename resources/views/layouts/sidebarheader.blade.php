<div class="page-header">
    <nav class="navbar navbar-expand-lg d-flex justify-content-between">
        <div class="" id="navbarNav">
            <ul class="navbar-nav" id="leftNav">
                <li class="nav-item">
                    <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                </li>
                <li class="nav-item" style="padding: 5px 0;">
                    <button class="darkModeSwitch" id="switch">
                        <span><i class="fas fa-sun"></i></span>
                        <span><i class="fas fa-moon"></i></span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="logo">
            @desktop
                <a class="navbar-brand"
                    style="background: url({{ '/storage/public/' . \App\Models\Setting::find(1)->icono }}) center center no-repeat;background-size: cover;"
                    href="#"></a>
            @elsedesktop
                <a class="navbar-brand"
                    style="background: url({{ '/storage/public/' . \App\Models\Setting::find(1)->icono }}) center center no-repeat;background-size: cover;"
                    href="#"></a>
            @enddesktop
        </div>
        <div class="" id="headerNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img style="max-width: 60px; border-radius:50%"
                            src="{{ '/storage/users/' . Auth::user()->image }}" alt="img"></a>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                        <a class="dropdown-item" href="{{ route('index.shop') }}" target="_blank">
                            <i data-feather="shopping-cart"></i> {{ __('Shop') }}
                        </a>


                        <a class="dropdown-item"
                            href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i data-feather="log-out"></i>{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>

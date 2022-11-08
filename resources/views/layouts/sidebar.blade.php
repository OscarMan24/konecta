<div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
        <li class="sidebar-title">
            {{ __('Main') }}
        </li>
        @can('users.index')
            <li class="{{ request()->is('panel/users') ? 'active-page' : '' }}">
                <a href="{{ route('index.users') }}"><i data-feather="user"></i>{{ __('Users') }}</a>
            </li>
        @endcan

        @can('categoria.index')
            <li class="{{ request()->is('panel/category') ? 'active-page' : '' }}">
                <a href="{{ route('index.categoria') }}"><i data-feather="filter"></i>{{ __('Category') }}</a>
            </li>
        @endcan

        @can('productos.index')
            <li class="{{ request()->is('panel/products') ? 'active-page' : '' }}">
                <a href="{{ route('index.products') }}"><i data-feather="coffee"></i>{{ __('Products') }}</a>
            </li>
        @endcan

        <li class="sidebar-title">
            {{ __('Settings') }}
        </li>

        @can('roles.index')
            <li class="{{ request()->is('panel/rol-and-permissions') ? 'active-page' : '' }}">
                <a href="{{ route('index.rols') }}"><i data-feather="shield"></i>{{ __('Roles') }}</a>
            </li>
        @endcan

        @can('setting.index')
            <li class="{{ request()->is('panel/setting') ? 'active-page' : '' }}">
                <a href="{{ route('index.setting') }}"><i data-feather="sliders"></i>{{ __('Setting') }}</a>
            </li>
        @endcan
    </ul>
</div>

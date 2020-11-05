@if (Gate::allows('is-super-user'))
    <li class="nav-item dropdown">
        <a id="lockyNavDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Locky Apps
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lockyNavDropdown">
            @can('view', App\User::class)
                <a class="dropdown-item" href="{{ route('users.index') }}">{{ __('locky::messages.user') }}s</a>
            @endcan
            @can('view', Dainsys\Locky\Role::class)
                <a class="dropdown-item" href="{{ route('roles.index') }}">{{ __('locky::messages.roles') }}</a>
            @endcan
            @can('view', Dainsys\Locky\Permission::class)
                <a class="dropdown-item" href="{{ route('permissions.index') }}">{{ __('locky::messages.permission') }}s</a>
            @endcan
        </div>
    </li>
@endif
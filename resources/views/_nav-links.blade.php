<li class="nav-item dropdown">
    <a id="lockyNavDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Locky Apps
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lockyNavDropdown">
        @can('view', App\User::class)
            <a class="dropdown-item" href="{{ route('users.index') }}">{{ __('Users') }}</a>
        @endcan
        @can('view', Dainsys\Locky\Role::class)
            <a class="dropdown-item" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
        @endcan
        @can('view', Dainsys\Locky\Permission::class)
            <a class="dropdown-item" href="{{ route('permissions.index') }}">{{ __('Permissions') }}</a>
        @endcan
    </div>
</li>
@if (Gate::allows('is-super-user'))
    <li class="nav-item dropdown">
        <a id="lockyNavDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Locky Apps
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lockyNavDropdown">
            @can('viewAny', app(\Dainsys\Locky\Contracts\UserContract::class))
                <a class="dropdown-item" href="{{ route('locky.users.index') }}">{{ __('locky::messages.user') }}s</a>
            @endcan
            @can('is-super-user')
                <a class="dropdown-item" href="{{ route('locky.users.index') }}">{{ __('locky::messages.user') }}s</a>
            @endcan
            @can('viewAny', Dainsys\Locky\Models\Role::class)
                <a class="dropdown-item" href="{{ route('locky.roles.index') }}">{{ __('locky::messages.roles') }}</a>
            @endcan
            @can('viewAny', Dainsys\Locky\Models\Permission::class)
                <a class="dropdown-item" href="{{ route('locky.permissions.index') }}">{{ __('locky::messages.permission') }}s</a>
            @endcan
        </div>
    </li>
@endif
@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ __('locky::messages.roles_list') }}</h4>

            @include('locky::roles.create', ['action' => 'CREATE'])

            <table class="table table table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        <th>{{ __('locky::messages.name') }}</th>
                        <th>{{ __('locky::messages.user') }}s</th>
                        <th>{{ __('locky::messages.permission') }}s</th>
                        <th>{{ __('locky::messages.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td scope="row">{{ $role->name }}</td>
                                <td>                                   
                                    @foreach ($role->users as $user)
                                        <span class="badge badge-pill badge-primary">
                                            {{ $user->name }}
                                        </span>
                                    @endforeach 
                                </td>
                                <td>                        
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge badge-pill badge-warning">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">{{ __('locky::messages.edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@endsection


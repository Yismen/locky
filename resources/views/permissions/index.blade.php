@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="row justify-content-around">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4>{{ __('locky::messages.permissions_list') }}</h4>
                </div>
                <div class="card-body">
                    @include('locky::permissions.create', ['action' => 'CREATE'])
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body p-0">
                    <table class="table table table-inverse table-sm">
                        <thead class="thead-inverse">
                            <tr>
                                <th>{{ __('locky::messages.name') }}</th>
                                <th>{{ __('locky::messages.user') }}s</th>
                                <th>{{ __('locky::messages.roles') }}</th>
                                <th>{{ __('locky::messages.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td scope="row">{{ $permission->name }}</td>
                                        <td>
                                            @foreach ($permission->users as $user)
                                                <span class="badge badge-pill badge-primary">{{ $user->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($permission->roles as $role)
                                                <span class="badge badge-pill badge-success">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">{{ __('locky::messages.edit') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ __('locky::messages.users_list') }}</h4>

            @include('locky::users.create', ['action' => 'CREATE'])

            <table class="table table table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        <th>{{ __('locky::messages.name') }}</th>
                        <th>{{ __('locky::messages.email') }}</th>
                        <th>{{ __('locky::messages.roles') }}</th>
                        <th>{{ __('locky::messages.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td scope="row">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-pill badge-primary">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">{{ __('locky::messages.edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@endsection


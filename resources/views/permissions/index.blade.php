@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ __('locky::messages.permissions_list') }}</h4>

            @include('locky::permissions.create', ['action' => 'CREATE'])

            <table class="table table table-inverse">
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
                                </td>
                                <td>
                                </td>
                                <td>
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning">{{ __('locky::messages.edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@endsection


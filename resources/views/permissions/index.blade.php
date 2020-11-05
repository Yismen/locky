@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Permissions List</h4>

            @include('locky::permissions.create', ['action' => 'CREATE'])

            <table class="table table table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        <th>Name</th>
                        <th>Users</th>
                        <th>Roles</th>
                        <th>Actions</th>
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
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@endsection


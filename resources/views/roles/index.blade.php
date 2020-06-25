@extends('locky::app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Roles List</h4>

            @include('locky::roles.create', ['action' => 'CREATE'])

            <table class="table table table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Name</th>
                        <th>Users</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td scope="row">{{ $role->name }}</td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@endsection


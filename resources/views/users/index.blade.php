@extends('locky::app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Users List</h4>

            @include('locky::users.create', ['action' => 'CREATE'])

            <table class="table table table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
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
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@endsection


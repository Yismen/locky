@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="row justify-content-around">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4>
                        {{ __('locky::messages.users_list') }}
                        <span class="badge badge-pill badge-info text-white">{{ $users->count() }}</span>
                    </h4>
                </div>
                <div class="card-body">        
                    @include('locky::users.create', ['action' => 'CREATE'])
                </div>                
            </div>

            <div class="card mt-2 ">
                <div class="card-body p-0">                            
                    <div class="table-responsive">
                        <table class="table table table-inverse table-sm table-hover">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>{{ __('locky::messages.name') }}</th>
                                    <th>{{ __('locky::messages.email') }}</th>
                                    <th>{{ __('locky::messages.roles') }}</th>
                                    <th>{{ __('locky::messages.status') }}</th>
                                    <th>{{ __('locky::messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="{{ $user->inactivated_at ? 'text-danger' : '' }}">
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
                                                {{ $user->inactivated_at ? 'Inactive' : '' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">{{ __('locky::messages.edit') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>
                {{ __('locky::messages.edit') }} {{ __('locky::messages.role') }} {{ $role->name }}
                <a href="{{ route('roles.index') }}" class="float-right">{{ __('locky::messages.roles_list') }}</a>
            </h4>

            <form action="{{ route('roles.update', $role->id) }}" method="post">
                @csrf
                @method('PUT')
                
                @include('locky::roles._form', ['action' => 'UPDATE'])
            </form>
            
        </div>
    </div>
@endsection


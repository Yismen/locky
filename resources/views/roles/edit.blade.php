@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="row justify-content-around">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4>
                        {{ __('locky::messages.edit') }} {{ __('locky::messages.role') }} - {{ $role->name }}
                        <a href="{{ route('locky.roles.index') }}" class="float-right" title="{{ __('locky::messages.roles_list') }}">{{ __('locky::messages.list') }}</a>
                    </h4>
                </div>
                <div class="card-body">        
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        
                        @include('locky::roles._form', ['action' => 'UPDATE'])
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection


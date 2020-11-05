@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="row justify-content-around">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="m-0">
                        {{ __('locky::messages.edit') }} {{ __('locky::messages.user') }} - {{ $user->name }}
                        <a href="{{ route('users.index') }}" class="float-right" title="{{ __('locky::messages.users_list') }}">{{ __('locky::messages.list') }}</a>
                    </h4>
                </div>
                <div class="card-body">      
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')                        
                        @include('locky::users._form', ['action' => 'UPDATE'])
                    </form>                    
                </div>
            </div>
        </div>
    </div>
@endsection


@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>
                {{ __('locky::messages.edit') }} {{ __('locky::messages.user') }} {{ $user->name }}
                <a href="{{ route('users.index') }}" class="float-right">{{ __('locky::messages.users_list') }}</a>
            </h4>

            <form action="{{ route('users.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')
                
                @include('locky::users._form', ['action' => 'UPDATE'])
            </form>
            
        </div>
    </div>
@endsection


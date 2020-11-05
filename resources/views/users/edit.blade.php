@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>
                Edit User {{ $user->name }}
                <a href="{{ route('users.index') }}" class="float-right">Users List</a>
            </h4>

            <form action="{{ route('users.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')
                
                @include('locky::users._form', ['action' => 'UPDATE'])
            </form>
            
        </div>
    </div>
@endsection


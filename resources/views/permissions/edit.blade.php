@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>
                Edit Permission {{ $permission->name }}
                <a href="{{ route('permissions.index') }}" class="float-right">Permissions List</a>
            </h4>

            <form action="{{ route('permissions.update', $permission->id) }}" method="post">
                @csrf
                @method('PUT')
                
                @include('locky::permissions._form', ['action' => 'UPDATE'])
            </form>
            
        </div>
    </div>
@endsection


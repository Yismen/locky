@extends('locky::app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>
                Edit Role {{ $role->name }}
                <a href="{{ route('roles.index') }}" class="float-right">Roles List</a>
            </h4>

            <form action="{{ route('roles.update', $role->id) }}" method="post">
                @csrf
                @method('PUT')
                
                @include('locky::roles._form', ['action' => 'UPDATE'])
            </form>
            
        </div>
    </div>
@endsection


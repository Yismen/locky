@extends('locky::app')

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
                
                @include('locky::users._form')
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
            </form>
            
        </div>
    </div>
@endsection


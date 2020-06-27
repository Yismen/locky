<form action="{{ route('users.store') }}" method="post">
    @csrf
    
    @include('locky::users._form', ['user' => new App\User()])
</form>
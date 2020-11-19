<form action="{{ route('roles.store') }}" method="post">
    @csrf
    
    @include('locky::roles._form', ['role' => new Dainsys\Locky\Models\Role()])
</form>
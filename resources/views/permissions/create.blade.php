<form action="{{ route('permissions.store') }}" method="post">
    @csrf
    
    @include('locky::permissions._form', ['permission' => new Dainsys\Locky\Models\Permission()])
</form>
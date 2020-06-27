<div class="row justify-content-around">
    <div class="col-sm-8">
        <div class="form-group">
            <div class="input-group mb-3">
                <input type="text" 
                    class="form-control" 
                    name="name" 
                    value="{{ old('name') ?? $permission->name }}" 
                    placeholder="Name" aria-label="Name" 
                    aria-describedby="button-addon2"
                >
                <div class="input-group-append">
                    <button class="btn btn-{{ $action == 'CREATE' ? 'primary' : 'warning' }}" type="submit" id="button-addon2">{{ $action }}</button>
                </div>
            </div>
        </div>
    </div>    
</div>

@if ($action == 'UPDATE')
    <div class="row">
        <div class="col-sm-6">
            <h5>Users</h5>           
        
            @foreach ($users as $user)
                <div class="form-check">
                    <label 
                        class="form-check-label {{ $user->hasAnyPermission($permission->name) ? 'bg-primary px-1 text-white' : '' }}" 
                    >
                        <input type="checkbox" 
                            class="form-check-input" 
                            name="users[]" 
                            id="" 
                            value="{{ $user->id }}" 
                            {{ $user->hasAnyPermission($permission->name) ? 'checked' : '' }}
                        >
                        {{ $user->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="col-sm-6">
            <h5>Roles</h5>           
        
            @foreach ($roles as $role)
                <div class="form-check">
                    <label 
                        class="form-check-label {{ $role->hasAnyPermission($permission->name) ? 'bg-warning px-1 text-' : '' }}" 
                    >
                        <input type="checkbox" 
                            class="form-check-input" 
                            name="roles[]" 
                            id="" 
                            value="{{ $role->id }}" 
                            {{ $role->hasAnyPermission($permission->name) ? 'checked' : '' }}
                        >
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
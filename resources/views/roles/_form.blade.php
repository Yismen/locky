<div class="row justify-content-around">
    <div class="col-sm-8">
        <div class="form-group">
            <x-locky-input-field-addon
                type="text"
                :field-value="old('name', $role->name)" 
                field-name="name" 
                label-name="Role Name:"
            />
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
                        class="form-check-label {{ $user->hasRole($role->name) ? 'bg-primary px-1 text-white' : '' }}" 
                    >
                        <input type="checkbox" 
                            class="form-check-input" 
                            name="users[]" 
                            id="" 
                            value="{{ $user->id }}" 
                            {{ $user->hasRole($role->name) ? 'checked' : '' }}
                        >
                        {{ $user->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="col-sm-6">
            <h5>Permissions</h5>           
        
            @foreach ($permissions as $permission)
                <div class="form-check">
                    <label 
                        class="form-check-label {{ $permission->hasRole($role->name) ? 'bg-warning px-1 text-black' : '' }}" 
                    >
                        <input type="checkbox" 
                            class="form-check-input" 
                            name="permissions[]" 
                            id="" 
                            value="{{ $permission->id }}" 
                            {{ $permission->hasRole($role->name) ? 'checked' : '' }}
                        >
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
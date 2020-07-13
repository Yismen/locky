<div class="row justify-content-around">
    <div class="col-sm-8">
        <div class="form-group">            
            <x-dc-input-field-addon
                type="text"
                :field-value="old('name', $permission->name)" 
                field-name="name" 
                btn-class="{{ $action == 'UPDATE' ? 'btn-warning': 'btn-primary' }}"
                button-action="{{ $action == 'UPDATE' ? 'UPDATE' : 'CREATE' }}"
                label-name="Permission Name:"
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
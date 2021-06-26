<div class="row">
    {{-- Roles --}}
    <div class="col-md-6">       
        <h4>{{ __('locky::messages.roles_list') }}</h4>                 
        <div class="row">
            @foreach ($roles->split(2) as $chunk)
                <div class="col-lg-6">
                    @foreach ($chunk as $role)
                        <div class="form-check">
                            <label 
                                class="form-check-label {{ in_array($role->id, (array) $selected_roles) ? 'font-weight-bold form-check-label text-success' : '' }}" 
                            >
                                <input type="checkbox" 
                                    class="form-check-input" 
                                    wire:model="selected_roles"
                                    wire:loading.attr="disabled"
                                    wire:change="updateRole({{ $role->id }})" 
                                    value="{{ $role->id }}" 
                                    {{ in_array($role->id, (array) $selected_roles) ? 'checked' : '' }}
                                >
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    {{-- Users --}}
    <div class="col-md-6">       
        <h4>{{ __('locky::messages.users_list') }}</h4>                 
        <div class="row">
            @foreach ($users->split(2) as $chunk)
                <div class="col-lg-6">
                    @foreach ($chunk as $user)
                        <div class="form-check">
                            <label 
                                class="form-check-label {{ $user->hasAnyPermission($permission->name) ? 'font-weight-bold form-check-label text-primary' : '' }}" 
                            >
                                <input type="checkbox" 
                                    class="form-check-input" 
                                    name="selected_users"
                                    wire:loading.attr="disabled"
                                    wire:change="updateUser({{ $user->id }})" 
                                    value="{{ $user->id }}" 
                                    {{ $user->hasAnyPermission($permission->name) ? 'checked' : '' }}
                                >
                                {{ $user->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
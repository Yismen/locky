<div class="row">
    {{-- Permissions --}}
    <div class="col-md-6">       
        <h4>{{ __('locky::messages.permissions_list') }}</h4>                 
        <div class="row">
            @foreach ($permissions->split(2) as $chunk)
                <div class="col-lg-6">
                    @foreach ($chunk as $permission)
                        <div class="form-check">
                            <label 
                                class="form-check-label {{ $role->hasPermissionTo($permission->name) ? 'font-weight-bold form-check-label text-success' : '' }}" 
                            >
                                <input type="checkbox" 
                                    class="form-check-input" 
                                    name="selected_permissions"
                                    wire:loading.attr="disabled"
                                    wire:change="updatePermission({{ $permission->id }})" 
                                    value="{{ $permission->id }}" 
                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                >
                                {{ $permission->name }}
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
                                class="form-check-label {{ in_array($user->id, (array) $selected_users) ? 'font-weight-bold form-check-label text-primary' : '' }}" 
                            >
                                <input type="checkbox" 
                                    class="form-check-input" 
                                    wire:model="selected_users"
                                    wire:loading.attr="disabled"
                                    wire:change="updateUser({{ $user->id }})" 
                                    value="{{ $user->id }}" 
                                    {{ in_array($user->id, (array) $selected_users) ? 'checked' : '' }}
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
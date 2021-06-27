<div class="row">
    <div class="col-md-12">                            
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text"
            class="form-control @error('fields.name') is-invalid @enderror" wire:model.debounce.350ms="fields.name" id="name" aria-describedby="name" placeholder="">
            @error('fields.name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>                          
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">                            
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="text"
            class="form-control @error('fields.email') is-invalid @enderror" wire:model.debounce.350ms="fields.email" id="email" aria-describedby="email" placeholder="">
            @error('fields.name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>                          
            @enderror
        </div>
    </div>
    <div class="col-md-6">                            
        <div class="form-group">
            @unless ($is_editing)
                <label for="password">{{ __('locky::messages.password') }}</label>
                <input type="password"
                class="form-control @error('fields.password') is-invalid @enderror" wire:model.debounce.350ms="fields.password" id="password" aria-describedby="password" placeholder="">
                @error('fields.password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                          
                @enderror                                        
            @endunless
        </div>
    </div>
</div>

<div>
    @if ($is_editing)
    <div class="row">
        {{-- Roles --}}
        <div class="col-md-6">       
            <h4>{{ __('locky::messages.roles_list') }}</h4>                 
            <div class="row">
                @foreach ($roles->split(2) as $chunk)
                    <div class="col-lg-6" wire:key="{{ $loop->index }}">
                        @foreach ($chunk as $role)
                            <div class="form-check" wire:key="{{ $loop->index }}">
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
        {{-- Permissions --}}
        <div class="col-md-6">       
            <h4>{{ __('locky::messages.permissions_list') }}</h4>                 
            <div class="row">
                @foreach ($permissions->split(2) as $chunk)
                    <div class="col-lg-6" wire:key="{{ $loop->index }}">
                        @foreach ($chunk as $permission)
                            <div class="form-check">
                                <label 
                                    class="form-check-label {{ $user->hasPermissionTo($permission->name) ? 'font-weight-bold form-check-label text-primary' : '' }}" 
                                >
                                    <input type="checkbox" 
                                        class="form-check-input" 
                                        wire:loading.attr="disabled"
                                        wire:change="updatePermission({{ $permission->id }})" 
                                        value="{{ $permission->id }}" 
                                        {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                    >
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
</div>
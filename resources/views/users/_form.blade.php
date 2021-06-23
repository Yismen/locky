<div class="row">
    <div class="col-sm-12 col-lg-4">
        <div class="form-group">
            <x-dc-input-field 
                :field-value="old('name', $user->name)" 
                field-name="name" 
                label-name="{{ __('locky::messages.name') }}"
            />
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="form-group">
            <x-dc-input-field 
                :field-value="old('email', $user->email)" 
                field-name="email" 
                label-name="{{ __('locky::messages.email') }}"
            />
        </div>
    </div>
    @if ($action == 'CREATE')
        <div class="col-sm-12 col-lg-4">
            <div class="form-group">
                <x-dc-input-field 
                    type="password"
                    :field-value="old('password', $user->password)" 
                    field-name="password" 
                    label-name="{{ __('locky::messages.password') }}"
                />
            </div>
        </div>
    @else
        <div class="col-sm-12 col-lg-4">
            <div class="form-group text-{{ $user->inactivated_at ? 'danger' : 'success' }}">
              <label for="inactivated_at">{{ $user->inactivated_at ? 'Inactive' : 'Active' }}</label>
              <input type="date"
                class="form-control" name="inactivated_at" id="inactivated_at" aria-describedby="helpId" placeholder=""
                value="{{ $user->inactivated_at }}"
                >                
                <small id="helpId" class="form-text text-muted">Remove to activate employee.</small>
            </div>
        </div>
    @endif
    <div class="col-sm-12 mb-2">        
        <div class="input-group-append">
            <button class="btn btn-{{ $action == 'CREATE' ? 'primary' : 'warning' }}" type="submit" id="button-addon2">{{ $action == 'UPDATE' ? __('locky::messages.update') : __('locky::messages.create') }}</button>
        </div>
    </div>
</div>


    
@if ($action == 'UPDATE')
<div class="row">
    {{-- Roles --}}
    <div class="col-sm-6">
        <div class="card mt-2">
            <div class="card-header bg-success text-white py-2">
                <h5 class="m-0">
                    {{ __('locky::messages.roles') }}
                    <span class="badge badge-pill badge-success text-white">
                        {{ "{$user->roles->count()} / {$roles->count()}"}}
                    </span>
                </h5>    
            </div>
            <div class="card-body row justify-content-between py-1">
                @foreach ($roles->split(2) as $chunk)
                    <div class="col-6">                                            
                        @foreach ($chunk as $role)
                            <div class="form-check">
                                <label 
                                    class="form-check-label {{ $user->hasRole($role->name) ? 'bg-success px-1 text-white' : '' }}" 
                                >
                                    <input type="checkbox" 
                                        class="form-check-input" 
                                        name="roles[]" 
                                        id="" 
                                        value="{{ $role->id }}" 
                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                    >
                                    {{ $role->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Permissions --}}
    <div class="col-sm-6">
        <div class="card mt-2">
            <div class="card-header bg-warning text-dark py-2">
                <h5 class="m-0">
                    {{ __('locky::messages.permissions') }}
                    <span class="badge badge-pill badge-warning text-dark">
                        {{ "{$user->permissions->count()} / {$permissions->count()}"}}
                    </span>
                </h5>    
            </div>
            <div class="card-body row justify-content-between py-1">
                @foreach ($permissions->split(2) as $chunk)
                    <div class="col-6">                                            
                        @foreach ($chunk as $permission)
                            <div class="form-check">
                                <label 
                                    class="form-check-label {{ $user->hasPermissionTo($permission->name) ? 'bg-warning px-1 text-dark' : '' }}" 
                                >
                                    <input type="checkbox" 
                                        class="form-check-input" 
                                        name="permissions[]" 
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
</div>
@endif
<div class="form-group">            
    <x-dc-input-field-addon
        type="text"
        :field-value="old('name', $permission->name)" 
        field-name="name" 
        btn-class="{{ $action == 'UPDATE' ? 'btn-warning': 'btn-primary' }}"
        button-action="{{ $action == 'UPDATE' ? __('locky::messages.update') : __('locky::messages.create') }}"
        label-name="{{ __('locky::messages.permission') }} {{ __('locky::messages.name') }}:"
    />
</div>

@if ($action == 'UPDATE')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">{{ __('locky::messages.user') }}s</h5>           
                </div>
                <div class="card-body px-2 py-1 row">
                    @foreach ($users->split(2) as $chunk)
                        <div class="col-lg-6">
                            @foreach ($chunk as $user)
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
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-warning text-black">
                    <h5 class="m-0">{{ __('locky::messages.roles') }}</h5>           
                </div>
                <div class="card-body px-2 py-1 row">
                    @foreach ($roles->split(2) as $chunk)
                        <div class="col-lg-6">
                            @foreach ($chunk as $role)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<div class="form-group">
    <x-dc-input-field-addon
        type="text"
        :field-value="old('name', $role->name)" 
        btn-class="{{ $action == 'UPDATE' ? 'btn-warning': 'btn-primary' }}"
        button-action="{{ $action == 'UPDATE' ? __('locky::messages.update') : __('locky::messages.create') }}"
        field-name="name" 
        label-name="{{ __('locky::messages.role') }} {{ __('locky::messages.name') }}:"
    />
</div>

@if ($action == 'UPDATE')
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">{{ __('locky::messages.user') }}s</h5> 
                </div>
                <div class="card-body px-3 py-1 row">
                    @foreach ($users->split(2) as $chunk)
                        <div class="col-lg-6">
                            @foreach ($chunk as $user)
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
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="m-0">{{ __('locky::messages.permission') }}s</h5>   
                </div>
                <div class="card-body px-3 py-1 row">
                    @foreach ($permissions->split(2) as $chunk)
                        <div class="col-lg-6">
                            @foreach ($chunk as $permission)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-sm-12 {{ $action == 'CREATE' ? 'col-lg-4' : 'col-lg-6' }}">
        <div class="form-group">
            <x-dc-input-field 
                :field-value="old('name', $user->name)" 
                field-name="name" 
                label-name="{{ __('locky::messages.name') }}"
            />
        </div>
    </div>
    <div class="col-sm-12 {{ $action == 'CREATE' ? 'col-lg-4' : 'col-lg-6' }}">
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
    @endif
    <div class="col-sm-12 mb-2">        
        <div class="input-group-append">
            <button class="btn btn-{{ $action == 'CREATE' ? 'primary' : 'warning' }}" type="submit" id="button-addon2">{{ $action == 'UPDATE' ? __('locky::messages.update') : __('locky::messages.create') }}</button>
        </div>
    </div>
    
@if ($action == 'UPDATE')
    <div class="col-sm-12 col-lg-6">
        <h5>{{ __('locky::messages.role') }}s</h5>
        
        @foreach ($roles as $role)
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
@endif
</div>
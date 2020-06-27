<div class="row">
    <div class="col-sm-12 {{ $action == 'CREATE' ? 'col-lg-4' : 'col-lg-6' }}">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text"
                class="form-control" name="name" id="name" aria-describedby="name"
                value="{{ old('name') ?? $user->name }}">
          </div>
    </div>
    <div class="col-sm-12 {{ $action == 'CREATE' ? 'col-lg-4' : 'col-lg-6' }}">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email"
                class="form-control" name="email" id="email" aria-describedby="email"
                value="{{ old('email') ?? $user->email }}">
                {{--  <small id="email" class="form-text text-muted">Help text</small>  --}}
        </div>
    </div>
    @if ($action == 'CREATE')
        <div class="col-sm-12 col-lg-4">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text"
                    class="form-control" name="password" id="password" aria-describedby="password"
                    value="{{ old('password') ?? $user->password }}">
                    {{--  <small id="email" class="form-text text-muted">Help text</small>  --}}
            </div>
        </div>
    @endif
    <div class="col-sm-12 mb-2">        
        <div class="input-group-append">
            <button class="btn btn-{{ $action == 'CREATE' ? 'primary' : 'warning' }}" type="submit" id="button-addon2">{{ $action }}</button>
        </div>
    </div>
    
@if ($action == 'UPDATE')
    <div class="col-sm-12 col-lg-6">
        <h5>Roles</h5>
        
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
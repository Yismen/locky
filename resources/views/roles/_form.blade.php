<div class="row justify-content-around">
    <div class="col-sm-8">
        <div class="form-group">
            <div class="input-group mb-3">
                <input type="text" 
                    class="form-control" 
                    name="name" 
                    value="{{ old('name') ?? $role->name }}" 
                    placeholder="Name" aria-label="Name" 
                    aria-describedby="button-addon2"
                >
                <div class="input-group-append">
                    <button class="btn btn-{{ $action == 'CREATE' ? 'primary' : 'warning' }}" type="submit" id="button-addon2">{{ $action }}</button>
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-sm-6">Users</div>
    <div class="col-sm-6">Permissions</div>
</div>